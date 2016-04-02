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
        print_r(get_class($this->minkContext));
        
        $this->minkContext->visit('node/add/video');
        $this->minkContext->printLastResponse();
        $this->minkContext->fillField('title[0][value]', '@todo, future video. Randomize and track?');
        // @todo, fine-grain date and timezone handling.
        $this->minkContext->fillField('field_date_published[0][value][date]', '2016-04-29');
        $this->minkContext->fillField('field_date_published[0][value][time]', '12:01:59');
        
        
        
        $this->minkContext->pressButton('Save and publish');
        
        
        
        

    }
}


