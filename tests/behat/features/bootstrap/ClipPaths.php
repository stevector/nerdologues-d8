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

  /**
   * @When I create an Event with a date in the future
   */
  public function iCreateAnEventWithADateInTheFuture()
  {
    $time = time() + (60 * 60 * 72);
    $this->iCreateAnEvent($time);
  }

  /**
   * @When I create an Event with a date in the past
   */
  public function iCreateAnEventWithADateInThePast()
  {
    $time = time() - (60 * 60 * 72);
    $this->iCreateAnEvent($time);
  }


  public function iCreateAnEvent($time)
  {
    $this->minkContext->visit('node/add/event');
    $event_title = 'event title ' . $time;
    $this->minkContext->fillField('title[0][value]', $event_title);
    // @todo, is this how variable are supposed to be passed around.
    $this->event_title = $event_title;
    // @todo, fine-grain date and timezone handling.
    $this->minkContext->fillField('field_dates[0][value][date]', date('Y-m-d', $time));
    $this->minkContext->fillField('field_dates[0][value][time]', date("H:i:s", $time));
    $this->minkContext->pressButton('Save and publish');
    $this->minkContext->visit('/');
  }


  /**
   * @Then that event does not appears on the homepage
   */
  public function thatEventDoesNotAppearsOnTheHomepage()
  {
    $this->minkContext->visit('/');
    $this->minkContext->assertNotLinkVisible($this->event_title);
  }

  /**
   * @Then that event appears on the homepage
   */
  public function thatEventAppearsOnTheHomepage()
  {
    $this->minkContext->visit('/');
    $this->minkContext->assertLinkVisible($this->event_title);
  }

  /**
   * @Then that event appears on the events page in the past events section
   */
  public function thatEventAppearsOnTheEventsPageInThePastEventsSection()
  {
    $this->minkContext->visit('events');
    $this->minkContext->assertLinkRegion($this->event_title, "Past events");
  }

  /**
   * @Then that event appears on the events page in the upcoming events section
   */
  public function thatEventAppearsOnTheEventsPageInTheUpcomingEventsSection()
  {
    $this->minkContext->visit('events');
    $this->minkContext->assertLinkRegion($this->event_title, "Upcoming events");
  }
}
