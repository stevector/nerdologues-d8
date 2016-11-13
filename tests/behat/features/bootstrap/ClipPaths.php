<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Drupal\DrupalExtension\Context\MinkContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;

/**
 * Define application features from the specific context.
 */
class ClipPaths implements Context, SnippetAcceptingContext {

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
   * @When I go to it's clip page
   */
  public function iGoToItSClipPage()
  {
    $this->minkContext->clickLink('Edit');

    $clip_path = str_replace('edit', 'clips-page', $this->minkContext->getSession()->getCurrentUrl());

    print_r($clip_path);
    $this->minkContext->visit($clip_path);


    print_r($this->minkContext->getSession()->getCurrentUrl());


    print_r("



    ");

    print_r($this->minkContext->getSession()->getStatusCode());



    print_r("



    ");


  }
}
