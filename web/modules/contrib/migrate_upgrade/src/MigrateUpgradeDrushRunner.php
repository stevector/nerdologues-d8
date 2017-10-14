<?php

namespace Drupal\migrate_upgrade;

use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\migrate\Event\MigrateEvents;
use Drupal\migrate\Event\MigrateIdMapMessageEvent;
use Drupal\migrate\MigrateExecutable;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\migrate_drupal\MigrationConfigurationTrait;
use Drupal\migrate_plus\Entity\Migration;
use Drupal\migrate_plus\Entity\MigrationGroup;
use Drupal\Core\Database\Database;

class MigrateUpgradeDrushRunner {

  use MigrationConfigurationTrait;
  use StringTranslationTrait;

  /**
   * The list of migrations to run and their configuration.
   *
   * @var \Drupal\migrate\Plugin\Migration[]
   */
  protected $migrationList;

  /**
   * MigrateMessage instance to display messages during the migration process.
   *
   * @var \Drupal\migrate_upgrade\DrushLogMigrateMessage
   */
  protected static $messages;

  /**
   * The Drupal version being imported.
   *
   * @var string
   */
  protected $version;

  /**
   * The state key used to store database configuration.
   *
   * @var string
   */
  protected $databaseStateKey;

  /**
   * List of D6 node migration IDs we've seen.
   *
   * @var array
   */
  protected $nodeMigrations = [];

  /**
   * From the provided source information, instantiate the appropriate migrations
   * in the active configuration.
   *
   * @throws \Exception
   */
  public function configure() {
    $legacy_db_key = drush_get_option('legacy-db-key');
    if (!empty($legacy_db_key)) {
      $connection = Database::getConnection('default', drush_get_option('legacy-db-key'));
      $this->version = $this->getLegacyDrupalVersion($connection);
      $database_state['key'] = drush_get_option('legacy-db-key');
      $database_state_key = 'migrate_drupal_' . $this->version;
      \Drupal::state()->set($database_state_key, $database_state);
      \Drupal::state()->set('migrate.fallback_state_key', $database_state_key);
    }
    else {
      $db_url = drush_get_option('legacy-db-url');
      $db_spec = drush_convert_db_from_db_url($db_url);
      $db_prefix = drush_get_option('legacy-db-prefix');
      $db_spec['prefix'] = $db_prefix;
      $connection = $this->getConnection($db_spec);
      $this->version = $this->getLegacyDrupalVersion($connection);
      $this->createDatabaseStateSettings($db_spec, $this->version);
    }

    $this->databaseStateKey = 'migrate_drupal_' . $this->version;
    $migrations = $this->getMigrations($this->databaseStateKey, $this->version);
    $this->migrationList = [];
    foreach ($migrations as $migration) {
      $this->applyFilePath($migration);
      $this->expandNodeMigrations($migration);
      $this->migrationList[$migration->id()] = $migration;
    }
  }

  /**
   * Adds the source base path configuration to relevant migrations.
   *
   * @param \Drupal\migrate\Plugin\MigrationInterface $migration
   *   Migration to alter with the provided path.
   */
  protected function applyFilePath(MigrationInterface $migration) {
    $destination = $migration->getDestinationConfiguration();
    if ($destination['plugin'] === 'entity:file') {
      // Make sure we have a single trailing slash.
      $source_base_path = rtrim(drush_get_option('legacy-root'), '/') . '/';
      $source = $migration->getSourceConfiguration();
      $source['constants']['source_base_path'] = $source_base_path;
      $migration->set('source', $source);
    }
  }

  /**
   * For D6 term_node migrations, make sure the nid reference is expanded.
   *
   * @param \Drupal\migrate\Plugin\MigrationInterface $migration
   *   Migration to alter with the list of node migrations.
   */
  protected function expandNodeMigrations(MigrationInterface $migration) {
    $source = $migration->getSourceConfiguration();
    // Track the node migrations as we see them.
    if ($source['plugin'] == 'd6_node') {
      $this->nodeMigrations[] = $migration->id();
    }
    elseif ($source['plugin'] == 'd6_term_node' || $source['plugin'] == 'd6_term_node_revision') {
      if ($source['plugin'] == 'd6_term_node') {
        $id_property = 'nid';
      }
      else {
        $id_property = 'vid';
      }
      // If the ID mapping is to the underived d6_node migration, replace
      // it with an expanded list of node migrations.
      $process = $migration->getProcess();
      $new_nid_process = [];
      foreach ($process[$id_property] as $delta => $plugin_configuration) {
        if ($plugin_configuration['plugin'] == 'migration' &&
            is_string($plugin_configuration['migration']) &&
            substr($plugin_configuration['migration'], -7) == 'd6_node') {
          $plugin_configuration['migration'] = $this->nodeMigrations;
        }
        $new_nid_process[$delta] = $plugin_configuration;
      }
      $migration->setProcessOfProperty($id_property, $new_nid_process);
    }
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
    foreach ($this->migrationList as $migration_id => $migration) {
      drush_print(dt('Upgrading @migration', ['@migration' => $migration_id]));
      $executable = new MigrateExecutable($migration, static::$messages);
      // drush_op() provides --simulate support.
      drush_op([$executable, 'import']);
    }
  }

  /**
   * Export the configured migration plugins as configuration entities.
   */
  public function export() {
    $db_info = \Drupal::state()->get($this->databaseStateKey);

    // Create a group to hold the database configuration.
    $group = [
      'id' => $this->databaseStateKey,
      'label' => 'Import from Drupal ' . $this->version,
      'description' => 'Migrations originally generated from drush migrate-upgrade --configure-only',
      'source_type' => 'Drupal ' . $this->version,
      'shared_configuration' => [
        'source' => [
          'key' => 'drupal_' . $this->version,
        ]
      ]
    ];

    // Only add the database connection info to the configuration entity
    // if it was passed in as a parameter.
    if (!empty(drush_get_option('legacy-db-url'))) {
      $group['shared_configuration']['source']['database'] = $db_info['database'];
    }

    $group = MigrationGroup::create($group);
    $group->save();
    foreach ($this->migrationList as $migration_id => $migration) {
      drush_print(dt('Exporting @migration as @new_migration',
        ['@migration' => $migration_id, '@new_migration' => $this->modifyId($migration_id)]));
      $entity_array['id'] = $migration_id;
      $entity_array['migration_group'] = $this->databaseStateKey;
      $entity_array['migration_tags'] = $migration->get('migration_tags');
      $entity_array['label'] = $migration->get('label');
      $entity_array['source'] = $migration->getSourceConfiguration();
      $entity_array['destination'] = $migration->getDestinationConfiguration();
      $entity_array['process'] = $migration->get('process');
      $entity_array['migration_dependencies'] = $migration->getMigrationDependencies();
      $migration_entity = Migration::create($this->substituteIds($entity_array));
      $migration_entity->save();
    }
  }

  /**
   * Rewrite any migration plugin IDs so they won't conflict with the core
   * IDs.
   *
   * @param $entity_array
   *   A configuration array for a migration.
   *
   * @return array
   *   The migration configuration array modified with new IDs.
   */
  protected function substituteIds($entity_array) {
    $entity_array['id'] = $this->modifyId($entity_array['id']);
    foreach ($entity_array['migration_dependencies'] as $type => $dependencies) {
      foreach ($dependencies as $key => $dependency) {
        $entity_array['migration_dependencies'][$type][$key] = $this->modifyId($dependency);
      }
    }
    $this->substituteMigrationIds($entity_array['process']);
    return $entity_array;
  }

  /**
   * Recursively substitute IDs for migration plugins.
   *
   * @param mixed $process
   */
  protected function substituteMigrationIds(&$process) {
    if (is_array($process)) {
      // We found a migration plugin, change the ID.
      if (isset($process['plugin']) && $process['plugin'] == 'migration') {
        if (is_array($process['migration'])) {
          $new_migration = [];
          foreach ($process['migration'] as $migration) {
            $new_migration[] = $this->modifyId($migration);
          }
          $process['migration'] = $new_migration;
        }
        else {
          $process['migration'] = $this->modifyId($process['migration']);
        }
      }
      else {
        // Recurse on each array member.
        foreach ($process as &$subprocess) {
          $this->substituteMigrationIds($subprocess);
        }
      }
    }
  }

  /**
   * @param $id
   *   The original core plugin ID.
   *
   * @return string
   *   The ID modified to serve as a configuration entity ID.
   */
  protected function modifyId($id) {
    return drush_get_option('migration-prefix', 'upgrade_') . str_replace(':', '_', $id);
  }

  /**
   * Rolls back the configured migrations.
   */
  public function rollback() {
    static::$messages = new DrushLogMigrateMessage();
    $database_state_key = \Drupal::state()->get('migrate.fallback_state_key');
    $database_state = \Drupal::state()->get($database_state_key);
    $db_spec = $database_state['database'];
    $connection = $this->getConnection($db_spec);
    $version = $this->getLegacyDrupalVersion($connection);
    $migrations = $this->getMigrations('migrate_drupal_' . $version, $version);

    // Roll back in reverse order.
    $this->migrationList = array_reverse($migrations);

    foreach ($migrations as $migration) {
      drush_print(dt('Rolling back @migration', ['@migration' => $migration->id()]));
      $executable = new MigrateExecutable($migration, static::$messages);
      // drush_op() provides --simulate support.
      drush_op([$executable, 'rollback']);
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
