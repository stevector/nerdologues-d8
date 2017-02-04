<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Drupal\DrupalExtension\Context\MinkContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\TableNode;

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
    $clip_path = str_replace('edit', 'clips', $this->minkContext->getSession()->getCurrentUrl());
    print_r($clip_path);
    $this->minkContext->visit($clip_path);
    print_r($this->minkContext->getSession()->getCurrentUrl());
  }

  /**
   * @Then the following aliases are created and valid
   */
  public function theFollowingAliasesAreCreatedAndValid(TableNode $fields)
  {
    foreach ($fields->getHash() as $field => $value) {
      $this->minkContext->visit('admin/config/search/path/add');

      $this->minkContext->fillField('Existing system path', $value['Existing system path']);
      $this->minkContext->fillField('Path alias', $value['Path alias']);
      $this->minkContext->pressButton('Save');
      $this->minkContext->visit($value['Path alias']);
      $this->minkContext->assertPageContainsText($value['Expected text']);
    }
  }
}
