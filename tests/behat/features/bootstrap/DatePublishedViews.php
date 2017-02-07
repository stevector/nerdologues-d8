<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Drupal\DrupalExtension\Context\MinkContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;

/**
 * Define application features from the specific context.
 */
class DatePublishedViews implements Context, SnippetAcceptingContext {

    /** @var \Behat\MinkExtension\Context\MinkContext */
    private $minkContext;

    /** @BeforeScenario */
    // Thanks http://docs.behat.org/en/v3.0/cookbooks/context_communication.html
    // Also see https://github.com/Behat/Behat/issues/96
    public function gatherContexts(BeforeScenarioScope $scope)
    {
        $environment = $scope->getEnvironment();

        $this->minkContext = $environment->getContext('Drupal\DrupalExtension\Context\MinkContext');
    }

    /**
     * @When I create a video with a published date in the future
     */
    public function iCreateAVideoWithAPublishedDateInTheFuture()
    {
      $time = time() + (60 * 60 * 72);
      $this->iCreateAVideo($time);
    }

    /**
     * @Then that video does not appear on the video page
     */
    public function thatVideoDoesNotAppearOnTheVideoPage()
    {
        $this->minkContext->visit('videos');
        $this->minkContext->assertNotLinkVisible($this->video_title);
    }

    /**
     * @When I create a video with a published date in the past
     */
    public function iCreateAVideoWithAPublishedDateInThePast()
    {
      $time = time() - (60 * 60 * 72);
      $this->iCreateAVideo($time);
    }

    public function iCreateAVideo($time)
    {
      $this->minkContext->visit('node/add/video');
      $video_title = 'video title ' . $time . ' ' . rand();
      $this->minkContext->fillField('title[0][value]', $video_title);
      // @todo, is this how variable are supposed to be passed around.
      $this->video_title = $video_title;
      $this->node_title = $video_title;
      // @todo, fine-grain date and timezone handling.
      $this->minkContext->fillField('field_date_published[0][value][date]', date('Y-m-d', $time));
      $this->minkContext->fillField('field_date_published[0][value][time]', date("H:i:s", $time));
      $this->minkContext->pressButton('Save and publish');
      $this->minkContext->visit('');
    }


    /**
     * @Then that video appears on the video page
     */
    public function thatVideoAppearsOnTheVideoPage()
    {
        $this->minkContext->visit('videos');
        $this->minkContext->assertLinkVisible($this->video_title);
    }


  /**
   * @Then it appears on the homepage :arg1 region.
   */
  public function itAppearsOnTheHomepageRegion($arg1)
  {
    $this->minkContext->visit('');
    $this->minkContext->assertLinkRegion($this->node_title, $arg1);
  }

  /**
   * @Then it does not appear the homepage :arg1 region.
   */
  public function itDoesNotAppearTheHomepageRegion($arg1)
  {
    $this->minkContext->visit('');
    $this->minkContext->assertNotLinkRegion($this->node_title, $arg1);
  }


}
