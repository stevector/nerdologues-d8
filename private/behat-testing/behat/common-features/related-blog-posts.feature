  Feature: Relate blog posts block
      In order to reuse content


      @api
      Scenario: Related blog posts
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
