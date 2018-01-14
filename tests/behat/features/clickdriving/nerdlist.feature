Feature: Nerdlist
  In order promote members of the group
  As a content creator
  I need to create bios and have them appear on the nerd list

  @api @current
  Scenario: Bio without proper term does not appear on the nerd page.
    Given I log in as a content_administrator
    When I visit "node/add/person"
    And I fill in "title[0][value]" with "Some Random Name"
    And I check the box "Published"
    And I press "Save"
    # Reload the page so that the title isn't seen simply in the status message for node creation.
    And I reload the page
    Then I should not see "Some Random Name"
    And I should get a "404" HTTP response
    When I visit "nerds"
    Then I should not see "Some Random Name"

  @api @current
    Scenario: Bio with 'Current Member' term does appear on nerd page..
      Given I log in as a content_administrator
      Given a "member_designations" term with the name "Current Member"
      When I visit "node/add/person"
      # @todo, figure out random handling.
      And I fill in "title[0][value]" with "New Nerdologues Member"
      And I check "Current Member"
      And I check "Viewable bio page"
      And I check the box "Published"
      And I press "Save"
      And I reload the page
      # Reload the page so that the title isn't seen simply in the status message for node creation.
      Then I should see "New Nerdologues Member"
      And I should get a "200" HTTP response
      When I visit "nerds"
      Then I should see "New Nerdologues Member"
