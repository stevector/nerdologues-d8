Feature: Hide upcoming events on Pagination
  In order to make the site readable
  As a content creator
  The upcoming events block should be hidden after I click on the pager for events in the past

  @api
  Scenario: Events page
    Given I am logged in as a user with the "content_administrator" role
    And there are over ten events with dates in the past

    And I have made an upcoming event
    And I visit "events"
    Then I should see the heading "Upcoming events"
    And I click on the events page pager
    Then I should not see the heading "Upcoming events"

  @api
  Scenario: Home page
    Given there are over ten videos with published dates in the past
    And I have made an upcoming event
    When I click on the homepage pager
    Then I will not see the upcoming events block.


