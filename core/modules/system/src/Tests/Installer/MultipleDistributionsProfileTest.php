<?php

namespace Drupal\system\Tests\Installer;

use Drupal\Component\Serialization\Yaml;
use Drupal\Core\Extension\ExtensionDiscovery;
use Drupal\Core\Installer\Exception\TooManyDistributionsException;
use Drupal\Core\Site\Settings;
use Drupal\simpletest\InstallerTestBase;

/**
 * Tests multiple distribution profile support.
 *
 * @group Installer
 */
class MultipleDistributionsProfileTest extends InstallerTestBase {

  /**
   * The distribution profile info.
   *
   * @var array
   */
  protected $info;

  protected function setUp() {
    // Create two distributions.
    foreach (['distribution_one', 'distribution_two'] as $name) {
      $info = array(
        'type' => 'profile',
        'core' => \Drupal::CORE_COMPATIBILITY,
        'name' => $name .' profile',
        'distribution' => array(
          'name' => $name,
          'install' => array(
            'theme' => 'bartik',
          ),
        ),
      );
      // File API functions are not available yet.
      $path = $this->siteDirectory . '/profiles/' . $name;
      mkdir($path, 0777, TRUE);
      file_put_contents("$path/$name.info.yml", Yaml::encode($info));
    }
    // Install the first distribution.
    $this->profile = 'distribution_one';

    parent::setUp();
  }

  /**
   * Overrides InstallerTest::setUpLanguage().
   */
  protected function setUpLanguage() {
    $this->assertNoRaw('distribution_one');
    $this->assertNoRaw('distribution_two');
    // Verify that the "Choose profile" step appears.
    $this->assertText('Choose profile');

    parent::setUpLanguage();
  }

  /**
   * Overrides InstallerTest::setUpProfile().
   */
  protected function setUpProfile() {
    $this->assertText('distribution_one');
    $this->assertText('distribution_two');
    parent::setUpProfile();
  }

  /**
   * Confirms that the installation succeeded.
   */
  public function testInstalled() {
    $this->assertUrl('user/1');
    $this->assertResponse(200);
    // Confirm that we are logged-in after installation.
    $this->assertText($this->rootUser->getUsername());

    // Confirm that Drupal recognizes this distribution as the current profile.
    $this->assertEqual(\Drupal::installProfile(), 'distribution_one');
    $this->assertEqual(Settings::get('install_profile'), 'distribution_one', 'The install profile has been written to settings.php.');

    // Test that a site will multiple distributions will get an exception when
    // calling \Drupal\Core\DrupalKernel::getDistribution().
    try {
      $this->container->get('kernel')->getDistribution();
      $this->fail('TooManyDistributionsException exception thrown.');
    }
    catch (TooManyDistributionsException $e) {
      $this->pass('TooManyDistributionsException exception thrown.');
    }
    // To mirror the test in DistributionProfileExistingSettingsTest we reset
    // the discovered files in ExtensionDiscovery.
    // @see \Drupal\system\Tests\Installer\DistributionProfileExistingSettingsTest::testInstalled()
    ExtensionDiscovery::reset();
    $this->rebuildContainer();
    $this->pass('Container can be rebuilt as distribution is written to settings.php.');
  }

}
