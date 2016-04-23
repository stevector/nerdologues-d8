Feature: User migration

  @api
  Scenario: List of users
    Given I am logged in as a user with the "administrator" role
    When I visit "admin/people"
    Then I should see "Content Administrator" in the "EricGarneau" row
    Then I should see "Content Administrator" in the "StevePersch" row
    Given I click "Edit" in the "StevePersch" row
    Then the "mail" field should contain "stevepersch@gmail.com"
    

