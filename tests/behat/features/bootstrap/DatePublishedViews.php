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
        $this->minkContext->visit('node/add/video');
        $video_title = 'future video title';
        $this->minkContext->fillField('title[0][value]', $video_title);
        // @todo, is this how variable are supposed to be passed around.
        $this->video_title = $video_title;
        // @todo, fine-grain date and timezone handling.
        $this->minkContext->fillField('field_date_published[0][value][date]', date('Y-m-d', time() + (60 * 60 * 72)));
        $this->minkContext->fillField('field_date_published[0][value][time]', '12:01:59');
        $this->minkContext->pressButton('Save and publish');
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
        $this->minkContext->visit('node/add/video');
        $video_title = 'past video title';
        $this->minkContext->fillField('title[0][value]', $video_title);
        // @todo, is this how variable are supposed to be passed around.
        $this->video_title = $video_title;
        // @todo, fine-grain date and timezone handling.
        $this->minkContext->fillField('field_date_published[0][value][date]', date('Y-m-d', time() - (60 * 60 * 72)));
        $this->minkContext->fillField('field_date_published[0][value][time]', '12:01:59');
        $this->minkContext->pressButton('Save and publish');
    }

    /**
     * @Then that video appears on the video page
     */
    public function thatVideoAppearsOnTheVideoPage()
    {
        $this->minkContext->visit('videos');
        $this->minkContext->assertLinkVisible($this->video_title);
    }
}
