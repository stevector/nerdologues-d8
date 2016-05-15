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
