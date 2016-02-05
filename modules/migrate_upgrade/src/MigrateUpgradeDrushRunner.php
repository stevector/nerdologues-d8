<?php

/**
 * @file
 * Contains \Drupal\migrate_upgrade\MigrateUpgradeDrushRunner.
 */

namespace Drupal\migrate_upgrade;
use Drupal\migrate\Entity\Migration;
use Drupal\migrate\Entity\MigrationInterface;
use Drupal\migrate\Event\MigrateEvents;
use Drupal\migrate\Event\MigrateIdMapMessageEvent;
use Drupal\migrate\MigrateExecutable;
use Drupal\Core\StringTranslation\StringTranslationTrait;

class MigrateUpgradeDrushRunner {

  use MigrationCreationTrait;
  use StringTranslationTrait;

  /**
   * The list of migrations to run and their configuration.
   *
   * @var array
   */
  protected $migrationList;

  /**
   * MigrateMessage instance to display messages during the migration process.
   *
   * @var \Drupal\migrate_upgrade\DrushLogMigrateMessage
   */
  protected static $messages;

  /**
   * From the provided source information, instantiate the appropriate migrations
   * in the active configuration.
   *
   * @throws \Exception
   */
  public function configure() {
    $db_url = drush_get_option('legacy-db-url');
    $db_spec = drush_convert_db_from_db_url($db_url);
    $db_prefix = drush_get_option('legacy-db-prefix');
    $db_spec['prefix'] = $db_prefix;

    $this->migrationList = $this->createMigrations($db_spec, drush_get_option('legacy-root'));
  }

  /**
   * Run the configured migrations.
   */
  public function import() {
    static::$messages = new DrushLogMigrateMessage();
    if (drush_get_option('debug')) {
      \Drupal::service('event_dispatcher')->addListener(MigrateEvents::IDMAP_MESSAGE,
        [get_class(), 'onIdMapMessage']);
    }
    foreach ($this->migrationList as $migration_id) {
      /** @var MigrationInterface $migration */
      $migration = Migration::load($migration_id);
      drush_print(dt('Upgrading @migration', ['@migration' => $migration_id]));
      $executable = new MigrateExecutable($migration, static::$messages);
      // drush_op() provides --simulate support.
      drush_op([$executable, 'import']);
    }
  }

  /**
   * Rolls back the configured migrations.
   */
  public function rollback() {
    static::$messages = new DrushLogMigrateMessage();
    $query = \Drupal::entityQuery('migration');
    $names = $query->execute();

    // Order the migrations according to their dependencies.
    /** @var MigrationInterface[] $migrations */
    $migrations = \Drupal::entityManager()
       ->getStorage('migration')
       ->loadMultiple($names);
    // Assume we want all those tagged 'Drupal %'.
    foreach ($migrations as $migration_id => $migration) {
      $keep = FALSE;
      $tags = $migration->get('migration_tags');
      foreach ($tags as $tag) {
        if (strpos($tag, 'Drupal ') === 0) {
          $keep = TRUE;
          break;
        }
      }
      if (!$keep) {
        unset($migrations[$migration_id]);
      }
    }
    // Roll back in reverse order.
    $this->migrationList = array_reverse($migrations);

    foreach ($this->migrationList as $migration_id => $migration) {
      drush_print(dt('Rolling back @migration', ['@migration' => $migration_id]));
      $executable = new MigrateExecutable($migration, static::$messages);
      // drush_op() provides --simulate support.
      drush_op([$executable, 'rollback']);
      $migration->delete();
    }
  }

  /**
   * Display any messages being logged to the ID map.
   *
   * @param \Drupal\migrate\Event\MigrateIdMapMessageEvent $event
   *   The message event.
   */
  public static function onIdMapMessage(MigrateIdMapMessageEvent $event) {
    if ($event->getLevel() == MigrationInterface::MESSAGE_NOTICE ||
        $event->getLevel() == MigrationInterface::MESSAGE_INFORMATIONAL) {
      $type = 'status';
    }
    else {
      $type = 'error';
    }
    $source_id_string = implode(',', $event->getSourceIdValues());
    $message = t('Source ID @source_id: @message',
      ['@source_id' => $source_id_string, '@message' => $event->getMessage()]);
    static::$messages->display($message, $type);
  }

}
