Feature: Clip creation
  In order to create content efficiently
  As a content adminstrator
  I want podcast clips created for each story in an episode

  @api
  Scenario: Clip nodes created for each list item in a your stories podcast
    Given I am logged in as a user with the "content_administrator" role
    Given I am viewing a podcast with the title "Your Stories"
    When I visit "node/add/podcast_episode"
    And I select the radio button "Your Stories"
    And I fill in "title[0][value]" with "Some Random Episode"
    And I fill in "field_body[0][value]" with "<p>Maybe it seems weird</p><ul><li>Cover Stories: Love Never Felt So Good</li><li>James D'Amato: Progression</li><li>Nathan Robert: Will You Please Spend New Years Eve with Me?</li></ul><p>If you're in Chicago, come on down to our</p><ul><li>Cover Stories: Take Me to Church</li></ul>"

    And I press "Save and publish"
    Then I visit "admin/content"
    Then I should see the link "Cover Stories: Love Never Felt So Good"
    Then I should see the link "James D'Amato: Progression"
    Then I should see the link "Nathan Robert: Will You Please Spend New Years Eve with Me?"
    Then I should see the link "Cover Stories: Take Me to Church"

    And I click "Cover Stories: Take Me to Church"
    Then I should see the link "Your Stories" in the "From the podcast" region
    Then I should see the link "Some Random Episode" in the "From the episode" region


  @api
  Scenario: More link becomes visible after three clips

    Given I am logged in as a user with the "content_administrator" role
    Given a "member_designations" term with the name "Viewable bio page"

    #Make a person
    When I visit "node/add/person"
    And I fill in "title[0][value]" with "Jane Member"
    And I check "Viewable bio page"
    And I press "Save"

    # Make a podcast and episode.
    Given I am viewing a podcast with the title "Someone's cool podcast"
    Given I am logged in as a user with the "content_administrator" role
    When I visit "node/add/podcast_episode"
    And I fill in "title[0][value]" with "That one podcast episode"
    And I select the radio button "Someone's cool podcast"
    And I press "Save and publish"

    When I visit "node/add/clip"
    And I fill in "title[0][value]" with "A Clip of a story"
    And I select the radio button "Someone's cool podcast"
    And I fill in "field_ref_podcast_episode[0][target_id]" with "That one podcast episode"
    And I fill in "field_ref_creators[target_id]" with "Jane Member"
    And I press "Save and publish"
    # @todo, add check of mp3 player.
    Then I should see the link "Jane Member"

    And I click "Jane Member"
    And I should see the text "A Clip of a story"

    And I should not see the link "More Podcast Clips"




    When I visit "node/add/clip"
    And I fill in "title[0][value]" with "A second Clip of a story"
    And I select the radio button "Someone's cool podcast"
    And I fill in "field_ref_podcast_episode[0][target_id]" with "That one podcast episode"
    And I fill in "field_ref_creators[target_id]" with "Jane Member"
    And I press "Save and publish"
    Then I should see the link "Jane Member"

    And I click "Jane Member"
    And I should see the text "A Clip of a story"
    And I should see the text "A second Clip of a story"
    And I should not see the link "More Podcast Clips"



    When I visit "node/add/clip"
    And I fill in "title[0][value]" with "A third Clip of a story"
    And I select the radio button "Someone's cool podcast"
    And I fill in "field_ref_podcast_episode[0][target_id]" with "That one podcast episode"
    And I fill in "field_ref_creators[target_id]" with "Jane Member"
    And I press "Save and publish"
    Then I should see the link "Jane Member"

    And I click "Jane Member"
    And I should see the text "A Clip of a story"
    And I should see the text "A second Clip of a story"
    And I should see the text "A third Clip of a story"
    And I should not see the link "More Podcast Clips"


    When I visit "node/add/clip"
    And I fill in "title[0][value]" with "A 4th Clip of a story"
    And I select the radio button "Someone's cool podcast"
    And I fill in "field_ref_podcast_episode[0][target_id]" with "That one podcast episode"
    And I fill in "field_ref_creators[target_id]" with "Jane Member"
    And I press "Save and publish"
    Then I should see the link "Jane Member"

    And I click "Jane Member"
    And I should see the text "A second Clip of a story"
    And I should see the text "A third Clip of a story"
    And I should see the text "A 4th Clip of a story"
    # The oldest clip should fall off and now there is a link.
    And I should not see the text "A Clip of a story"

    # All four should be on the full list.
    And I click "More Podcast Clips"
    And I should see the text "A second Clip of a story"
    And I should see the text "A third Clip of a story"
    And I should see the text "A 4th Clip of a story"
    And I should see the text "A Clip of a story"


    And I click "That one podcast episode"
    And I click "Someone's cool podcast"
    And I go to it's clip page
    Then the response status code should be 200
    And I see the text "Someone's cool podcast: Clip Archive"







