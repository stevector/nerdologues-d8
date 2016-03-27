    




    Feature: Episode List
      In order to distribute episodes
      As a content creator
      I need to be able to create episodes and see them in the correct places.

      @api
      Scenario: Create new episode, see it on the episode list
        # @todo, change to content creator
        Given I am logged in as a user with the "administrator" role
        When I visit "node/add/podcast_episode"
        # @todo, figure out random handling.
        And I fill in "title[0][value]" with "Something random for title"
        And I select "Your Stories" from "From the podcast"
        And I press "Save and publish"
        Then I should see "Something random for title"

        # @todo Aliases need to be created.
        When I visit "podcasts/your-stories"
        Then I should see "Something random for title"

        When I visit "podcasts/your-stories/episodes"
        Then I should see "Something random for title"
