<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Drupal\DrupalExtension\Context\MinkContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;

/**
 * Define application features from the specific context.
 */
class CustomNode implements Context, SnippetAcceptingContext {

    /** @var \Behat\MinkExtension\Context\MinkContext */
    private $minkContext;

    /** @BeforeScenario */
    // Thanks http://docs.behat.org/en/v3.0/cookbooks/context_communication.html
    public function gatherContexts(BeforeScenarioScope $scope)
    {
        $environment = $scope->getEnvironment();

        $this->minkContext = $environment->getContext('Drupal\DrupalExtension\Context\MinkContext');
    }    
    
    /**
     * @When I create a video with a published date two minutes in the future
     */
    public function iCreateAVideoWithAPublishedDateTwoMinutesInTheFuture()
    {   
        $this->minkContext->visit('node/add/video');
        $this->minkContext->printLastResponse();
        // @todo
        $this->minkContext->fillField('title[0][value]', 'future video. Randomize and track?');
        // @todo, fine-grain date and timezone handling.
        $this->minkContext->fillField('field_date_published[0][value][date]', '2016-04-29');
        $this->minkContext->fillField('field_date_published[0][value][time]', '12:01:59');
        $this->minkContext->pressButton('Save and publish');
    }
    
    /**
     * @Then that video does not appear on the video page
     */
    public function thatVideoDoesNotAppearOnTheVideoPage()

    {
        $this->minkContext->visit('videos');
        $this->minkContext->printLastResponse();
        $this->minkContext->assertNotLinkVisible('future video. Randomize and track?');
        
    }    
}


