<?php

/**
 * @file
 * Command-line tools to aid performing and developing upgrade migrations.
 */

use Drupal\migrate_upgrade\MigrateUpgradeDrushRunner;

/**
 * Implements hook_drush_command().
 */
function migrate_upgrade_drush_command() {
  $items['migrate-upgrade'] = [
    'description' => 'Perform one or more upgrade processes.',
    'options' => [
      'legacy-db-url' => 'A Drupal 6 style database URL. Required.',
      'legacy-db-prefix' => 'Prefix of the legacy Drupal installation.',
      'legacy-root' => 'Site address or root of the legacy Drupal installation',
      'configure-only' => 'Set up the appropriate upgrade processes but do not perform them',
    ],
    'examples' => [
      'migrate-upgrade --legacy-db-url=\'mysql://root:pass@127.0.0.1/d6\'' => 'Upgrade a Drupal 6 database to Drupal 8',
    ],
    'drupal dependencies' => ['migrate_upgrade'],
  ];
  $items['migrate-upgrade-rollback'] = [
    'description' => 'Rolls back and removes upgrade migrations.',
    'examples' => [
      'migrate-upgrade-rollback' => 'Rolls back a previously-run upgrade',
    ],
    'drupal dependencies' => ['migrate_upgrade'],
  ];

  return $items;
}

/**
 * Execute the upgrade command, configuring the necessary migrations and
 * optionally perform the imports.
 */
function drush_migrate_upgrade() {
  $configure_only = drush_get_option('configure-only');

  $runner = new MigrateUpgradeDrushRunner();

  try {
    $runner->configure();
    if (!$configure_only) {
      $runner->import();
      \Drupal::state()->set('migrate_upgrade.performed', REQUEST_TIME);
    }
  }
  catch (\Exception $e) {
    drush_log($e->getMessage(), 'error');
  }
}

/**
 * Rolls back any upgrade migrations that are present, and deletes the migrations
 * themselves.
 */
function drush_migrate_upgrade_rollback() {
  if ($date_performed = \Drupal::state()->get('migrate_upgrade.performed')) {
    if (drush_confirm(dt('All migrations tagged as \'Drupal\' will be rolled back. Are you sure?'))) {
      $runner = new MigrateUpgradeDrushRunner();

      try {
        drush_log(dt('Rolling back the upgrades performed @date',
          ['@date' => \Drupal::service('date.formatter')->format($date_performed)]));
        $runner->rollback();
        \Drupal::state()->delete('migrate_upgrade.performed');
        drush_log(dt('Rolled back upgrades'));
      }
      catch (\Exception $e) {
        drush_log($e->getMessage(), 'error');
      }
    }
    else {
      drush_user_abort();
    }
  }
  else {
    drush_log(dt('No upgrade operation has been performed.'), 'warning');
  }
}
