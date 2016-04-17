<?php

/**
 * @file
 * Contains \Drupal\Tests\forum\Unit\Breadcrumb\ForumBreadcrumbBuilderBaseTest.
 */

namespace Drupal\Tests\nerdcustom\Unit\ClipCreator;
use Drupal\Tests\UnitTestCase;
use Drupal\nerdcustom\ClipGenerator;

/**
 * @coversDefaultClass \Drupal\forum\Breadcrumb\ForumBreadcrumbBuilderBase
 * @group nerdcustom
 */
class ClipCreatorTest extends UnitTestCase {

  /**
   * 
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    $this->entityManager = $this->getMock('Drupal\Core\Entity\EntityManagerInterface');
    $this->clipGenerator = new ClipGenerator($this->entityManager);    
  }

  /**
   * Tests ClipGenerator::extractClipTitles().
   *
   * @covers ::__construct
   */
  public function testExtractClipTitles() {
    $this->assertEquals('just getting started', $this->clipGenerator->extractClipTitles());    
  }
}
