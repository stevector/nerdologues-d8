<?php

/**
 * @file
 * Contains \Drupal\config_installer\Tests\ConfigInstallerTarballTest.
 */

namespace Drupal\config_installer\Tests;

/**
 * Tests the config installer profile by uploading a tarball.
 *
 * @group ConfigInstaller
 */
class ConfigInstallerTarballTest extends ConfigInstallerTestBase {

  /**
   * {@inheritdoc}
   */
  protected function setUpSyncForm() {
    // Upload the tarball.
    $this->drupalPostForm(NULL, array('files[import_tarball]' => $this->tarball), 'Save and continue');
  }

}
