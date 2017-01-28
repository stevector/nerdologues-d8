Feature: Event Redirect
  In order promote live events
  As a content creator
  I need event nodes to redirect to Facebook or wherever else has more information

  @api
  Scenario: Redirect event for content_administrator
    Given I am logged in as a user with the "content_administrator" role
    When I visit "node/add/event"
    And I fill in "Title" with "Your Stories in LA: Long Distance at UCB Sunset!"
    And I fill in "URL" with "https://www.facebook.com/events/699237613563919/"
    And I fill in "field_dates[0][value][date]" with "2013-01-31"
    And I fill in "field_dates[0][value][time]" with "19:00:00"
    And I press "Save and publish"
    Then I should be on "/events/699237613563919/"

  @api
  Scenario: Don't redirect event for administrator
    Given I am logged in as a user with the "administrator" role
    When I visit "node/add/event"
    And I fill in "Title" with "Your Stories in LA: Long Distance at UCB Sunset!"
    And I fill in "URL" with "https://www.facebook.com/events/699237613563919/"
    And I fill in "field_dates[0][value][date]" with "2013-01-31"
    And I fill in "field_dates[0][value][time]" with "19:00:00"
    And I press "Save and publish"
    Then I should be on "/events/your-stories-la-long-distance-ucb-sunset"

