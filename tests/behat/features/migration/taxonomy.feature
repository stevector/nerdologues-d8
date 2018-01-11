Feature: Taxonomy migration

  @api
  Scenario: Bio without proper term does not appear on the nerd page.
    Given I log in as an administrator
    When I visit "admin/structure/taxonomy"
    Then I should see "Blog Tags"
    Then I should see "iTunes Category"
    Then I should see "Member Designations"
    Then I should see "Tags"

    # Verify individual terms.
    When I visit "admin/structure/taxonomy/manage/member_designations/overview"
    Then I should see the link "Current Member"
    Then I should see the link "Emeritus"
    Then I should see the link "Founding Member"
    Then I should see the link "Honorary member"
    Then I should see the link "Viewable bio page"
