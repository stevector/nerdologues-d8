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
      $this->DrupalContext = $environment->getContext('Drupal\DrupalExtension\Context\DrupalContext');

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
    $this->event_time = $time;
    $this->minkContext->visit('node/add/event');
    $event_title = 'event title ' . $time;
    $this->minkContext->fillField('title[0][value]', $event_title);
    // @todo, is this how variable are supposed to be passed around.
    $this->event_title = $event_title;
    // @todo, fine-grain date and timezone handling.
    $this->minkContext->fillField('field_dates[0][value][date]', date('Y-m-d', $time));
    $this->minkContext->fillField('field_dates[0][value][time]', date("H:i:s", $time));

    $this->minkContext->checkOption("Publishing status");
    $this->minkContext->pressButton('Save');
    $this->minkContext->visit('/');
  }

  /**
   * @Then I should see the regular date text
   */
  public function iShouldSeeTheRegularDateText()
  {
    $this->minkContext->assertResponseContains(date('l, F j, Y - g:ia', $this->event_time));
  }

  /**
   * @Then I should not see the regular date text
   */
  public function iShouldNotSeeTheRegularDateText()
  {
    $this->minkContext->assertResponseNotContains(date('l, F j, Y - g:ia', $this->event_time));
  }

  /**
   * @Given there are over ten events with dates in the past
   */
  public function thereAreOverTenEventsWithDatesInThePast()
  {
    $i = 1;
    while ($i <= 11) {
      $this->iCreateAnEventWithADateInThePast();
      $i++;
    }
  }



  /**
   * @Given I have made an upcoming event
   *
   * This step is somewhat redundant. The reason for the redundancy is that it includes assertions.
   */
  public function iHaveMadeAnUpcomingEvent()
  {
    $this->iCreateAnEventWithADateInTheFuture();
    $this->thatEventAppearsOnTheHomepage();
    $this->thatEventAppearsOnTheEventsPageInTheUpcomingEventsSection();
  }


  /**
   * @When I click on the events page pager
   */
  public function iClickOnTheEventsPagePager()
  {
    $this->minkContext->visit('events');
    $this->minkContext->assertClick("Next page");
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

  /**
   * @When I edit the event and override the date text with :arg1
   */
  public function iEditTheEventAndOverrideTheDateTextWith($override_text)
  {
    $this->minkContext->visit('admin/content');
    $this->DrupalContext->assertClickInTableRow('Edit', $this->event_title);
    $this->minkContext->fillField('Date display text', $override_text);
    $this->minkContext->pressButton('Save');
  }

  /**
   * @Given I log in as an administrator
   */
  public function ILogInAsAnAdmin()
  {
    $this->minkContext->visit('user/logout');
    $this->minkContext->visit('user');
    $this->minkContext->fillField('Username', getenv('BEHAT_USER_ADMIN'));
    $this->minkContext->fillField('Password', getenv('BEHAT_PASS_ADMIN'));
    $this->minkContext->pressButton('Log in');
  }
  /**
   * @Given I log in as a content_administrator
   */
  public function ILogInAsAnContentAdmin()
  {
    $this->minkContext->visit('user/logout');
    $this->minkContext->visit('user');
    $this->minkContext->fillField('Username', getenv('BEHAT_USER_CONTENT_ADMIN'));
    $this->minkContext->fillField('Password', getenv('BEHAT_PASS_CONTENT_ADMIN'));
    $this->minkContext->pressButton('Log in');
  }

  /**
   * @Then the output matches the XML of :page on the Drupal 7 site.
   */
  public function theOutputMatchesTheXmlOfOnTheDrupalSite($page)
  {
    $d8_response = $this->minkContext->getSession()->getPage()->getContent();
    print_r($d8_response);
    $d7_base_url = "http://migr-prep3-nerdologues.pantheonsite.io/";
    $this->minkContext->visit($d7_base_url . $page);
    $this->minkContext->printLastResponse();

    $d7_response = $this->minkContext->getSession()->getPage()->getContent();

    //$this->minkContext->assertSession()->assert($d7_response, $d8_response);

    if ($d7_response !== $d8_response) {
      throw new \Exception('D7 feed does not match D8 feed');
    }
  }




}
