<?php

/**
 * @file
 * Contains \Drupal\Tests\nerdcustom\Unit\ClipCreator\ClipCreatorTest.
 */

namespace Drupal\Tests\nerdcustom\Unit\ClipCreator;
use Drupal\Tests\UnitTestCase;
use Drupal\nerdcustom\ClipCreator;

/**
 * Testing for ClipCreator.
 *
 * @coversDefaultClass \Drupal\nerdcustom\ClipCreator
 * @group nerdcustom
 */
class ClipCreatorTest extends UnitTestCase {

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->entityManager = $this->getMock('Drupal\Core\Entity\EntityManagerInterface');
    $this->clipCreator = new ClipCreator($this->entityManager);
  }

  /**
   * Tests ClipCreator::extractClipTitles().
   *
   * @param string $body_text
   *   The body text of a podcast_episode.
   * @param array $extracted_titles
   *   Clip titles extracted from body field.
   *
   * @dataProvider providerClipTitles
   * @covers ::extractClipTitles
   */
  public function testExtractClipTitles($body_text, array $extracted_titles) {
    $this->assertEquals($extracted_titles, $this->clipCreator->extractClipTitles($body_text));
  }

  /**
   * Data provider for testExtractClipTitles.
   *
   * @return array
   *   An array of test data.
   */
  public function providerClipTitles() {
    $data = array();

    $data[] = [
      '<ul><li>Test</li></ul>',
      ['Test']
    ];

    $data[] = [
      "<p>Maybe it seems weird</p><ul><li>Cover Stories: Love Never Felt So Good</li><li>James D'Amato: Progression</li><li>Nathan Robert: Will You Please Spend New Years Eve with Me?</li></ul><p>If you're in Chicago, come on down to our</p><ul><li>Cover Stories: Take Me to Church</li></ul>",
      [
        "Cover Stories: Love Never Felt So Good",
        "James D'Amato: Progression",
        "Nathan Robert: Will You Please Spend New Years Eve with Me?",
        "Cover Stories: Take Me to Church"
      ]
    ];

    return $data;
  }
}
