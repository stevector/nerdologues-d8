<?php

namespace Drupal\Tests\paragraphs\Functional;

use Drupal\Tests\BrowserTestBase;
use Drupal\Tests\paragraphs\FunctionalJavascript\LoginAdminTrait;
use Drupal\Tests\paragraphs\FunctionalJavascript\ParagraphsTestBaseTrait;

/**
 * Tests the Paragraphs user interface.
 *
 * @group paragraphs
 */
class ParagraphsExperimentalUiTest extends BrowserTestBase {

  use LoginAdminTrait;
  use ParagraphsTestBaseTrait;

  /**
   * Modules to enable.
   *
   * @var string[]
   */
  public static $modules = [
    'node',
    'paragraphs',
    'field',
    'field_ui',
    'block',
  ];

  /**
   * Tests if the paragraph type class is present when added.
   */
  public function testParagraphTypeClass() {
    $this->loginAsAdmin();
    // Add a Paragraphed test content.
    $this->addParagraphedContentType('paragraphed_test', 'paragraphs');

    $this->addParagraphsType('test_paragraph');
    $this->addParagraphsType('text');

    // Add paragraphs to a node and check if their type is present as a class.
    $this->drupalGet('node/add/paragraphed_test');
    $this->getSession()->getPage()->findButton('paragraphs_test_paragraph_add_more')->press();
    $this->assertSession()->responseContains('paragraph-type--test-paragraph');
    $this->getSession()->getPage()->findButton('paragraphs_text_add_more')->press();
    $this->assertSession()->responseContains('paragraph-type--text');
  }

}
