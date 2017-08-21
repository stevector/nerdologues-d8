<?php

namespace Drupal\Tests\cdn\Functional\Update;

use Drupal\system\Tests\Update\UpdatePathTestBase;

/**
 * Tests that existing sites are updated to the new defaults unless customized.
 *
 * @see cdn_update_8001()
 * @see https://www.drupal.org/node/2827998
 *
 * @group cdn
 */
class CdnDefaultSettingsUpdateTest extends UpdatePathTestBase {

  /**
   * {@inheritdoc}
   */
  protected function setDatabaseDumpFiles() {
    $this->databaseDumpFiles = [
      DRUPAL_ROOT . '/core/modules/system/tests/fixtures/update/drupal-8.bare.standard.php.gz',
      __DIR__ . '/../../../fixtures/update/drupal-8.cdn-cdn_update_8001.php',
    ];
  }

  /**
   * It's possible to automatically update the settings as long as the only
   * thing that's modified by the end user is the 'domain' (NULL by default).
   */
  public function testDefaultSettingsAreUpdated() {
    $expected_original_mapping = [
      'type' => 'simple',
      'domain' => 'cdn.example.com',
      'conditions' => [],
    ];
    $expected_updated_mapping = [
      'type' => 'simple',
      'domain' => 'cdn.example.com',
      'conditions' => [
        'not' => [
          'extensions' => ['css', 'js'],
        ],
      ],
    ];

    // Make sure we have the expected values before the update.
    $cdn_settings = $this->config('cdn.settings');
    $this->assertIdentical($expected_original_mapping, $cdn_settings->get('mapping'));

    $this->runUpdates();

    // Make sure we have the expected values after the update.
    $cdn_settings = $this->config('cdn.settings');
    $this->assertIdentical($expected_updated_mapping, $cdn_settings->get('mapping'));
  }

  /**
   * We consider the CDN mapping settings "customized" as soon as the 'type' or
   * 'conditions' keys are modified.
   */
  public function testCustomizedSettingsAreIgnored() {
    // First, customize the settings, like an end user would.
    $this->config('cdn.settings')->set('mapping.conditions', ['extensions' => ['zip']])->save();

    $expected_mapping = [
      'type' => 'simple',
      'domain' => 'cdn.example.com',
      'conditions' => [
        'extensions' => ['zip'],
      ],
    ];

    // Make sure we have the expected values before the update.
    $cdn_settings = $this->config('cdn.settings');
    $this->assertIdentical($expected_mapping, $cdn_settings->get('mapping'));

    $this->runUpdates();

    // Make sure we have the expected values after the update.
    $cdn_settings = $this->config('cdn.settings');
    $this->assertIdentical($expected_mapping, $cdn_settings->get('mapping'));
  }

}
