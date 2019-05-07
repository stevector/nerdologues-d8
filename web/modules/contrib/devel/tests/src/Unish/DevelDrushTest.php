<?php

namespace Drupal\Tests\devel\Unish;

use Unish\CommandUnishTestCase;

/**
 * @group devel
 * @group commands
 */
class DevelDrushTest extends CommandUnishTestCase {

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    $this->setUpDrupal(1, true);
    $this->drush('pm:enable', ['devel']);
  }

  /**
   * Test devel:services command.
   */
  public function testServices() {
    $this->drush('devel:services');
    $output = $this->getOutput();
    $this->assertContains('account_switcher', $output);
  }

}

