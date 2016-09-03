<?php
/**
 * @file
 * Enables modules and site configuration for a minimal site installation.
 */

use Drupal\Core\Config\StorageComparer;
use Drupal\Core\Config\ConfigImporter;
use Drupal\Core\Config\ConfigImporterException;
use Drupal\config_installer\Storage\SourceStorage;

/**
 * Need to do a manual include since this install profile never actually gets
 * installed so therefore its code cannot be autoloaded.
 */
include_once __DIR__ . '/src/Form/SiteConfigureForm.php';
include_once __DIR__ . '/src/Form/SyncConfigureForm.php';
include_once __DIR__ . '/src/Storage/SourceStorage.php';

/**
 * Implements hook_install_tasks_alter().
 */
function config_installer_install_tasks_alter(&$tasks, $install_state) {
  $key = array_search('install_profile_modules', array_keys($tasks));
  unset($tasks['install_profile_modules']);
  unset($tasks['install_profile_themes']);
  unset($tasks['install_install_profile']);
  $config_tasks = array(
    'config_installer_upload' => array(
      'display_name' => t('Upload config'),
      'type' => 'form',
      'function' => 'Drupal\config_installer\Form\SyncConfigureForm'
    ),
    'config_install_batch' => array(
      'display_name' => t('Install configuration'),
      'type' => 'batch',
    ),
    'config_installer_fix_profile' => [],
  );
  $tasks = array_slice($tasks, 0, $key, true) +
    $config_tasks +
    array_slice($tasks, $key, NULL , true);
  $tasks['install_configure_form']['function'] = 'Drupal\config_installer\Form\SiteConfigureForm';
}

/**
 * Creates a batch for the config importer to process.
 *
 * @see config_installer_install_tasks_alter()
 */
function config_install_batch() {
  // We need to manually trigger the installation of core-provided entity types,
  // as those will not be handled by the module installer.
  // @see install_profile_modules()
  install_core_entity_type_definitions();

  // Create a source storage that reads from sync.
  $listing = new \Drupal\Core\Extension\ExtensionDiscovery(\Drupal::root());
  $listing->setProfileDirectories([]);
  $sync = new SourceStorage(\Drupal::service('config.storage.sync'), $listing->scan('profile'));

  // Match up the site uuids, the install_base_system install task will have
  // installed the system module and created a new UUID.
  $system_site = $sync->read('system.site');
  \Drupal::configFactory()->getEditable('system.site')->set('uuid', $system_site['uuid'])->save();

  // Create the storage comparer and the config importer.
  $config_manager = \Drupal::service('config.manager');
  $storage_comparer = new StorageComparer($sync, \Drupal::service('config.storage'), $config_manager);
  $storage_comparer->createChangelist();
  $config_importer = new ConfigImporter(
    $storage_comparer,
    \Drupal::service('event_dispatcher'),
    $config_manager,
    \Drupal::service('lock.persistent'),
    \Drupal::service('config.typed'),
    \Drupal::service('module_handler'),
    \Drupal::service('module_installer'),
    \Drupal::service('theme_handler'),
    \Drupal::service('string_translation')
  );

  try {
    $sync_steps = $config_importer->initialize();

    // Implementing hook_config_import_steps_alter() in this file does not work
    // if using the 'drush site-install' command. Add the step to fix the import
    // profile before the last step of the configuration import.
    $last = array_pop($sync_steps);
    $sync_steps[] = 'config_installer_config_import_profile';
    $sync_steps[] = $last;

    $batch = array(
      'operations' => array(),
      'finished' => 'config_install_batch_finish',
      'title' => t('Synchronizing configuration'),
      'init_message' => t('Starting configuration synchronization.'),
      'progress_message' => t('Completed @current step of @total.'),
      'error_message' => t('Configuration synchronization has encountered an error.'),
      'file' => drupal_get_path('module', 'config') . '/config.admin.inc',
    );
    foreach ($sync_steps as $sync_step) {
      $batch['operations'][] = array('config_install_batch_process', array($config_importer, $sync_step));
    }

    return $batch;
  }
  catch (ConfigImporterException $e) {
    // There are validation errors.
    drupal_set_message(\Drupal::translation()->translate('The configuration synchronization failed validation.'));
    foreach ($config_importer->getErrors() as $message) {
      drupal_set_message($message, 'error');
    }
  }
}

/**
 * Processes the config import batch and persists the importer.
 *
 * @param \Drupal\Core\Config\ConfigImporter $config_importer
 *   The batch config importer object to persist.
 * @param string $sync_step
 *   The synchronisation step to do.
 * @param $context
 *   The batch context.
 *
 * @see config_install_batch()
 */
function config_install_batch_process(ConfigImporter $config_importer, $sync_step, &$context) {
  if (!isset($context['sandbox']['config_importer'])) {
    $context['sandbox']['config_importer'] = $config_importer;
  }

  $config_importer = $context['sandbox']['config_importer'];
  $config_importer->doSyncStep($sync_step, $context);
  if ($errors = $config_importer->getErrors()) {
    if (!isset($context['results']['errors'])) {
      $context['results']['errors'] = array();
    }
    $context['results']['errors'] += $errors;
  }
}

/**
 * Finish config importer batch.
 *
 * @see config_install_batch()
 */
function config_install_batch_finish($success, $results, $operations) {
  if ($success) {
    if (!empty($results['errors'])) {
      foreach ($results['errors'] as $error) {
        drupal_set_message($error, 'error');
        \Drupal::logger('config_sync')->error($error);
      }
      drupal_set_message(\Drupal::translation()->translate('The configuration was imported with errors.'), 'warning');
    }
    else {
      // Configuration sync needs a complete cache flush.
      drupal_flush_all_caches();
    }
  }
  else {
    // An error occurred.
    // $operations contains the operations that remained unprocessed.
    $error_operation = reset($operations);
    $message = \Drupal::translation()
      ->translate('An error occurred while processing %error_operation with arguments: @arguments', array(
        '%error_operation' => $error_operation[0],
        '@arguments' => print_r($error_operation[1], TRUE)
      ));
    drupal_set_message($message, 'error');
  }
}

/**
 * Processes profile as part of configuration sync.
 *
 * @param array $context.
 *   The batch context.
 * @param \Drupal\Core\Config\ConfigImporter $config_importer
 *   The config importer.
 *
 * @see config_installer_config_import_steps_alter()
 */
function config_installer_config_import_profile(array &$context, ConfigImporter $config_importer) {
  $orginal_profile = _config_installer_get_original_install_profile();
  if ($orginal_profile) {
    \Drupal::service('config.installer')
      ->setSyncing(TRUE)
      ->setSourceStorage($config_importer->getStorageComparer()->getSourceStorage());
    \Drupal::service('module_installer')->install([$orginal_profile], FALSE);
    module_set_weight($orginal_profile, 1000);
    $context['message'] = t('Synchronising install profile: @name.', array('@name' => $orginal_profile));
  }
  $context['finished'] = 1;
}

/**
 * Fixes configuration if the install profile has made changes in hook_install().
 *
 * @see config_installer_install_tasks_alter()
 */
function config_installer_fix_profile() {
  global $install_state;
  // It is possible that installing the profile makes unintended configuration
  // changes.
  $config_manager = \Drupal::service('config.manager');
  $storage_comparer = new StorageComparer(\Drupal::service('config.storage.sync'), \Drupal::service('config.storage'), $config_manager);
  $storage_comparer->createChangelist();
  if ($storage_comparer->hasChanges()) {
    // Swap out the install profile so that the profile module exists.
    $install_state['parameters']['profile'] =_config_installer_get_original_install_profile();
    system_list_reset();
    $config_importer = new ConfigImporter(
      $storage_comparer,
      \Drupal::service('event_dispatcher'),
      $config_manager,
      \Drupal::service('lock.persistent'),
      \Drupal::service('config.typed'),
      \Drupal::service('module_handler'),
      \Drupal::service('module_installer'),
      \Drupal::service('theme_handler'),
      \Drupal::service('string_translation')
    );
    try {
      $config_importer->import();
    }
    catch (ConfigImporterException $e) {
      // There are validation errors.
      drupal_set_message(\Drupal::translation()->translate('The configuration synchronization failed validation.'));
      foreach ($config_importer->getErrors() as $message) {
        drupal_set_message($message, 'error');
      }
    }
    // Replace the install profile so that the config_installer still works.
    $install_state['parameters']['profile'] = 'config_installer';
    system_list_reset();
  }
}

/**
 * Gets the original install profile name.
 *
 * @return string|null
 *   The name of the install profile from the sync configuration.
 */
function _config_installer_get_original_install_profile() {
  $original_profile = NULL;
  // Profiles need to be extracted from the install list if they are there.
  // This is because profiles need to be installed after all the configuration
  // has been processed.
  $listing = new \Drupal\Core\Extension\ExtensionDiscovery(\Drupal::root());
  $listing->setProfileDirectories([]);
  // Read directly from disk since the source storage in the config importer is
  // being altered to exclude profiles.
  $new_extensions = \Drupal::service('config.storage.sync')
                           ->read('core.extension')['module'];
  $profiles = array_intersect_key($listing->scan('profile'), $new_extensions);

  if (!empty($profiles)) {
    // There can be only one.
    $original_profile = key($profiles);
  }
  return $original_profile;
}
