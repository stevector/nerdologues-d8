Feature: Nerdlist
  In order promote members of the group
  As a content creator
  I need to create bios and have them appear on the nerd list

  @api
  Scenario: Bio without proper term does not appear on the nerd page.
    Given I am logged in as a user with the "administrator" role
    When I visit "admin/structure/taxonomy"
    Then I should see "Blog Tags"
    Then I should see "iTunes Category"
    Then I should see "Member Designations"
    Then I should see "Tags"
    
    When I visit "admin/structure/taxonomy/manage/member_designations/overview"
    Then I should see the link "Current Member"
    Then I should see the link "Emeritus"
    Then I should see the link "Founding Member"
    Then I should see the link "Honorary member"
    Then I should see the link "Viewable bio page"
