Feature: Hide upcoming events on Pagination
  In order to make the site readable
  As a content creator
  The upcoming events block should be hidden after I click on the pager for events in the past

  @api
  Scenario: Events page
    Given I log in as a content_administrator
    And there are over ten events with dates in the past

    And I have made an upcoming event
    And I visit "events"
    Then I should see the heading "Upcoming events"
    And I click on the events page pager
    Then I should not see the heading "Upcoming events"
