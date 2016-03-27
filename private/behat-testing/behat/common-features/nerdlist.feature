Feature: Nerdlist
  In order promote members of the group
  As a content creator
  I need to create bios and have them appear on the nerd list

  @api
  Scenario: Bio without proper term does not appear.
    # @todo, change to content creator
    Given I am logged in as a user with the "administrator" role
    When I visit "node/add/person"
    # @todo, figure out random handling.
    And I fill in "title[0][value]" with "Some Random Name"
#    And I select "Your Stories" from "From the podcast"
    And I press "Save and publish"
    Then I should see "Some Random Name"

    When I visit "nerds"
    Then I should not see "Some Random Name"

  @api
    Scenario: Bio with 'Current Member' term does not appear.
      # @todo, change to content creator
      Given I am logged in as a user with the "administrator" role
      When I visit "node/add/person"
      # @todo, figure out random handling.
      And I fill in "title[0][value]" with "New Nerdologues Member"
      And I check "Current Member"
      And I press "Save and publish"
      Then I should see "New Nerdologues Member"
      And I break
      When I visit "nerds"
      Then I should see "New Nerdologues Member"
