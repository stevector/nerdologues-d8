<?php

/**
 * @file
 * Contains \Drupal\config_installer\Tests\ConfigInstallerSyncTest.
 */

namespace Drupal\config_installer\Tests;

use Drupal\Core\Archiver\ArchiveTar;
use Drupal\Core\Config\FileStorage;

/**
 * Tests the config installer profile by having files in a sync directory.
 *
 * @group ConfigInstaller
 */
class ConfigInstallerSyncTest extends ConfigInstallerTestBase {

  protected $sync_dir;

  protected function setUp() {
    $this->sync_dir = 'public://' . $this->randomMachineName(128);
    parent::setUp();
  }

  /**
   * Ensures that the user page is available after installation.
   */
  public function testInstaller() {
    // Do assertions from parent.
    parent::testInstaller();

    // Do assertions specific to test.
    $this->assertEqual(drupal_realpath($this->sync_dir), config_get_config_directory(CONFIG_SYNC_DIRECTORY), 'The sync directory has been updated during the installation.');
    $this->assertEqual(USER_REGISTER_ADMINISTRATORS_ONLY, \Drupal::config('user.settings')->get('register'), 'Ensure standard_install() does not overwrite user.settings::register.');
    $this->assertEqual([], \Drupal::entityDefinitionUpdateManager()->getChangeSummary(), 'There are no entity or field definition updates.');
  }

  /**
   * {@inheritdoc}
   */
  protected function setUpSyncForm() {
    // Create a new sync directory.
    drupal_mkdir($this->sync_dir);

    // Extract the tarball into the sync directory.
    $archiver = new ArchiveTar($this->tarball, 'gz');
    $files = array();
    foreach ($archiver->listContent() as $file) {
      $files[] = $file['filename'];
    }
    $archiver->extractList($files, $this->sync_dir);

    // Change the user.settings::register so that we can test that
    // standard_install() does not override it.
    $sync = new FileStorage($this->sync_dir);
    $user_settings = $sync->read('user.settings');
    $user_settings['register'] = USER_REGISTER_ADMINISTRATORS_ONLY;
    $sync->write('user.settings', $user_settings);

    $this->drupalPostForm(NULL, array('sync_directory' => drupal_realpath($this->sync_dir)), 'Save and continue');
  }

}
