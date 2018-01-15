<?php

use Behat\Behat\Hook\Scope\AfterStepScope;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Drupal\DrupalExtension\Context\RawDrupalContext;

/**
 * Define application features from the specific context.
 */
class FeatureContext extends RawDrupalContext implements Context, SnippetAcceptingContext {
  /**
   * Initializes context.
   * Every scenario gets its own context object.
   *
   * @param array $parameters
   *   Context parameters (set them in behat.yml)
   */
  public function __construct(array $parameters = []) {
    // Initialize your context here
  }

  /**
   * @AfterStep
   */
  public function afterStep(AfterStepScope $scope)
  {
    // Do nothing on steps that pass
    $result = $scope->getTestResult();
    if ($result->isPassed()) {
      return;
    }
    // Otherwise, dump the page contents.
    $session = $this->getSession();
    $page = $session->getPage();
    $html = $page->getContent();
    $html = static::trimHead($html);
    print "::::::::::::::::::::::::::::::::::::::::::::::::\n";
  //  print $html . "\n";
    print "::::::::::::::::::::::::::::::::::::::::::::::::\n";
  }
  /**
   * Remove everything in the '<head>' element except the
   * title, because it is long and uninteresting.
   */
  protected static function trimHead($html)
  {
    $html = preg_replace('#\<head\>.*\<title\>#sU', '<head><title>', $html);
    $html = preg_replace('#\</title\>.*\</head\>#sU', '</title></head>', $html);
    return $html;
  }








}
