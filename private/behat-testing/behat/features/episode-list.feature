Feature: Episode List
  In order to distribute episodes
  As a content creator
  I need to be able to create episodes and see them in the correct places.

  @api
  Scenario: Create new episode, see it on the episode list
    # @todo, change to content creator
    Given I am logged in as a user with the "administrator" role
    Given I am viewing a "podcast" with the title "Your Stories"
    When I visit "node/add/podcast_episode"
    And I fill in "title[0][value]" with "Something random for title"
    And I select the radio button "Your Stories"
    And I press "Save and publish"
    Then I should see "Something random for title"

    # @todo Aliases need to be created.
    Given I am viewing a "podcast" with the title "Your Stories"
    Then I should see "Something random for title"



    When I visit "podcasts/your-stories/episodes"
    Then I should see "Something random for title"
