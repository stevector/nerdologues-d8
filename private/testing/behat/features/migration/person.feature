Feature: Person

  @api
  Scenario: Person bio pages
    Given I am logged in as a user with the "administrator" role
    When I visit "admin/content-migration"
    Then I should see the following table portion
    |Chris Geiger | Person | Current Member, Founding Member, Viewable bio page | public://geiger-square.png | public://geiger-square.png | Geiger |
    Then I should see the following table portion
    | Claire Friedman | Person | Emeritus, Viewable bio page | public://friedman-profile_0.jpg	| public://friedman-profile_0.jpg | Friedman |
    Then I should see the following table portion    
    | Renata Graw     | Person |                             |                                  |                                 | Graw |
