<?php

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
    $data = [];

    $data[] = [
      '<ul><li>Test</li></ul>',
      ['Test'],
    ];

    $data[] = [
      "<p>Maybe it seems weird</p><ul><li>Cover Stories: Love Never Felt So Good</li><li>James D'Amato: Progression</li><li>Nathan Robert: Will You Please Spend New Years Eve with Me?</li></ul><p>If you're in Chicago, come on down to our</p><ul><li>Cover Stories: Take Me to Church</li></ul>",
      [
        "Cover Stories: Love Never Felt So Good",
        "James D'Amato: Progression",
        "Nathan Robert: Will You Please Spend New Years Eve with Me?",
        "Cover Stories: Take Me to Church",
      ],
    ];

    return $data;
  }

  /**
   * Tests ClipCreator::ClipMp3FileName().
   *
   * @dataProvider providerMp3FileNames
   * @covers ::clipMp3FileName
   */
  public function testExtractClipMp3FileName($source_file, $story_title, $base_url, $start_seconds, $end_seconds, $resulting_cip) {
    $this->assertEquals($resulting_cip, $this->clipCreator->clipMp3FileName($source_file, $story_title, $base_url, $start_seconds, $end_seconds));
  }

  /**
   * Data provider for testClipMp3FileName.
   *
   * @return array
   *   An array of test data.
   */
  public function providerMp3FileNames() {
    $data = [];

    $data[] = [
      "https://podcasts.nerdologues.com/yourstories/HorrorStories22.mp3",
      "Cover Stories: Paint it Black",
      'https://media.nerdologues.com/clips/v1',
      // It shouldn't matter if these args are int or string.
      2643,
      "2855",
      "https://media.nerdologues.com/clips/v1/HorrorStories22--Cover-Stories--Paint-it-Black--2643-2855.mp3",
    ];

    return $data;
  }

}
