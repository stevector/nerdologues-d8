  Feature: In order to feature group members
   And protect privacy of non-members
   Only group members names should be linked from videos and podcast class.


  @api
  Scenario: video
    Given I am logged in as a user with the "administrator" role
  #  @todo, this part of the test should fail once migrations start
#    When I visit "admin/structure/taxonomy/manage/member_designations/overview"
#    Then I should not see the text "Viewable bio page"
#    And I follow "Add term"
#    And I fill in "name[0][value]" with "Viewable bio page"
#    And I press "Save"

    # Make two people
    When I visit "node/add/person"
    And I fill in "title[0][value]" with "Jane Member"
    And I check "Viewable bio page"
    And I press "Save"
    When I visit "node/add/person"
    And I fill in "title[0][value]" with "Joe Non-member"
    And I press "Save"


# make a video node

    When I visit "node/add/video"
    And I fill in "title[0][value]" with "Some video"
    And I fill in "field_ref_creators[0][target_id]" with "Jane Member"
    And I press "Save"
    Then I visit "admin/content"

    Then I click "Edit" in the "Some video" row

      And I fill in "field_ref_creators[1][target_id]" with "Joe Non-member"
And I press "Save"
And I follow "Some video"
    Then I should see the text "Some video"
    Then I should see the link "Jane Member"
    # Should see the text but not a link
    Then I should see the text "Joe Non-member"
    And I break
    Then I should not see the link "Joe Non-member"











  @api
  Scenario: Podcast clip
    # @todo, change to content creator
    Given I am logged in as a user with the "administrator" role
