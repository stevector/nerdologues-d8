Feature: Event dates
  In order to promote upcoming events
  As a content creator
  Events in the future will appear on the homepage and on the events page

  @api
  Scenario: Events with override date text
    Given I log in as a content_administrator
    When I create an Event with a date in the future
    Then that event appears on the homepage
    And I should see the regular date text
    When I edit the event and override the date text with "Event Coming Soon"
    # Todo, logged in users should see it here either.
    And I am not logged in
    Then that event appears on the homepage
    And I should not see the regular date text
    And I should see the text "Event Coming Soon"

  @api
  Scenario: Events in the future
    Given I log in as a content_administrator
    When I create an Event with a date in the future
    Then that event appears on the events page in the upcoming events section
    And that event appears on the homepage

  @api
  Scenario: Events in the past
    Given I log in as a content_administrator
    When I create an Event with a date in the past
    Then that event does not appears on the homepage
    And that event appears on the events page in the past events section
