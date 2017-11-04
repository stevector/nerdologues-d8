Feature: Nerdlist
  In order promote members of the group
  As a content creator
  I need to create bios and have them appear on the nerd list

  @api
  Scenario: Bio without proper term does not appear on the nerd page.
    Given I am logged in as a user with the "content_administrator" role
    When I visit "node/add/person"
    And I fill in "title[0][value]" with "Some Random Name"
    And I press "Save and publish"
    Then I should see "Some Random Name"
    When I visit "nerds"
    Then I should not see "Some Random Name"

  @api
    Scenario: Bio with 'Current Member' term does appear on nerd page..
      Given I am logged in as a user with the "content_administrator" role
      Given a "member_designations" term with the name "Current Member"
      When I visit "node/add/person"
      # @todo, figure out random handling.
      And I fill in "title[0][value]" with "New Nerdologues Member"
      And I check "Current Member"
      And I check the box "Publishing status"
      And I press "Save"
      Then I should see "New Nerdologues Member"

      When I visit "nerds"
      Then I should see "New Nerdologues Member"
