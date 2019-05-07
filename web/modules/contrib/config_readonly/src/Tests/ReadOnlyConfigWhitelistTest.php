<?php

namespace Drupal\config_readonly\Tests;

/**
 * Tests read-only module config whitelist functionality.
 *
 * @group ConfigReadOnly
 */
class ReadOnlyConfigWhitelistTest extends ReadOnlyConfigTest {

  public static $modules = [
    'config',
    'config_readonly',
    'node',
    'config_readonly_whitelist_test',
  ];

  /**
   * Ensure that the whitelist allows a read-only form to become saveable.
   */
  public function testWhitelist() {
    $this->createContentType([
      'type' => 'article1',
      'name' => 'Article1',
    ]);
    $this->createContentType([
      'type' => 'article2',
      'name' => 'Article2',
    ]);

    $this->turnOnReadOnlySetting();

    $this->drupalGet('admin/structure/types/manage/article1');
    $this->assertText('This form will not be saved because the configuration active store is read-only.', 'Warning shown on edit node type page.');

    $this->drupalGet('admin/structure/types/manage/article2');
    $this->assertNoText('This form will not be saved because the configuration active store is read-only.', 'Warning not show on edit node type page.');
  }

  /**
   * Test simple config with whitelist.
   */
  public function testSimpleConfig() {
    $this->drupalGet('admin/config/development/configuration/single/import');
    $this->assertNoText('This form will not be saved because the configuration active store is read-only.', 'Warning not shown on single config import page.');

    $this->drupalGet('admin/config/development/performance');
    $this->assertNoText('This form will not be saved because the configuration active store is read-only.', 'Warning not shown on performance config page.');

    $this->turnOnReadOnlySetting();
    $this->drupalGet('admin/config/development/configuration/single/import');
    $this->assertText('This form will not be saved because the configuration active store is read-only.', 'Warning shown on single config import page.');

    $this->drupalGet('admin/config/development/performance');
    $this->assertNoText('This form will not be saved because the configuration active store is read-only.', 'Warning not shown on performance config page.');
  }

}
