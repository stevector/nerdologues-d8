  Feature: In order to feature group members
   And protect privacy of non-members
   Only group members names should be linked from videos and podcast class.

  @api
  Scenario: video and clips
    Given I am logged in as a user with the "content_administrator" role
   Given a "member_designations" term with the name "Viewable bio page"

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
    Then I should not see the link "Joe Non-member"

    # CLIP
    Given I am viewing a podcast with the title "Someone's cool podcast"
    # PODCAST EPISODE
    Given I am logged in as a user with the "content_administrator" role
    When I visit "node/add/podcast_episode"
    And I fill in "title[0][value]" with "That one podcast episode"
    And I select the radio button "Someone's cool podcast"
    And I check the box "Publishing status"
    And I press "Save"
    When I visit "node/add/clip"
    And I fill in "title[0][value]" with "A Clip of a story"
    And I select the radio button "Someone's cool podcast"
    And I fill in "field_ref_podcast_episode[0][target_id]" with "That one podcast episode"
    And I fill in "field_ref_creators[target_id]" with "Joe Non-member, Jane Member"
    And I check the box "Publishing status"
    And I press "Save"
    Then I should see the link "Jane Member"
    # Should see the text but not a link
    Then I should see the text "Joe Non-member"
    Then I should not see the link "Joe Non-member"

    # Verify that the cache tags worked by editing the Joe Non-member
    Then I visit "admin/content"
    Then I click "Edit" in the "Joe Non-member" row
    And I check "Viewable bio page"
    And I press "Save"
    And I follow "Some video"
    Then I should see the link "Jane Member"
    # This assertion is the one really being tested.
    Then I should see the link "Joe Non-member"
