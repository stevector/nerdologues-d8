Feature: Event dates
  In order to promote upcoming events
  As a content creator
  Events in the future will appear on the homepage and on the events page

  @api
  Scenario: Events in the future
    Given I am logged in as a user with the "content_administrator" role
    When I create an Event with a date in the future
    Then that event appears on the homepage
    And that event appears on the events page in the upcoming events section
    # @todo
    # And that video does not appear the homepage "Nerds Online" section.

  @api
  Scenario: Events in the future
    Given I am logged in as a user with the "content_administrator" role
    When I create an Event with a date in the past
    Then that event does not appears on the homepage
    And that event appears on the events page in the past events section
