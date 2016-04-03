Feature: Pathauto

  @api
  Scenario: blog post
    # @todo role   
    Given I am logged in as a user with the "administrator" role
    When I visit "node/add/blog_post"
    And I fill in "title[0][value]" with "A Blog Post Title"
    And I fill in "field_date_published[0][value][date]" with "2015-10-31"
    And I fill in "field_date_published[0][value][time]" with "15:05:05"
    And I press "Save and publish"
    Then the response should contain "<link rel=\"canonical\" href=\"/blog/2015-10-31/blog-post-title\" />"
                                 
  @api
    Scenario: Podcast, Podcast Episode, and clip
    Given I am an anonymous user
    Given I am viewing a podcast with the title "Someone's cool podcast"
    Then the response should contain "<link rel=\"canonical\" href=\"/podcasts/someone-s-cool-podcast\" />"

    # PODCAST EPISODE
    # @todo role   
    Given I am logged in as a user with the "administrator" role
    When I visit "node/add/podcast_episode"
    And I fill in "title[0][value]" with "That one podcast episode"
    And I select the radio button "Someone's cool podcast"
    And I press "Save and publish"
    Then the response should contain "<link rel=\"canonical\" href=\"/podcasts/someone-s-cool-podcast/episodes/one-podcast-episode\" />"

    # CLIP
    When I visit "node/add/clip"
    And I fill in "title[0][value]" with "A Clip of a story"
    And I select the radio button "Someone's cool podcast"
    And I fill in "field_ref_podcast_episode[0][target_id]" with "That one podcast episode"
    And I press "Save and publish"
    Then the response should contain "<link rel=\"canonical\" href=\"/podcasts/someone-s-cool-podcast/clips/clip-story\" />"

  @api
  Scenario: Basic page
    Given I am an anonymous user
    Given I am viewing a page with the title "Some Random Basic Page"
    Then the response should contain "<link rel=\"canonical\" href=\"/some-random-basic-page\" />"

  @api
  Scenario: People
    Given I am an anonymous user
    Given I am viewing a person with the title "Another person"
    Then the response should contain "<link rel=\"canonical\" href=\"/nerds/another-person\" />"

  @api
  Scenario: location
    Given I am an anonymous user
    Given I am viewing a location with the title "A theatre test"
    Then the response should contain "<link rel=\"canonical\" href=\"/locations/theatre-test\" />"

  @api
  Scenario: event
    Given I am an anonymous user
    Given I am viewing a event with the title "Your Stories November"
    Then the response should contain "<link rel=\"canonical\" href=\"/events/your-stories-november\" />"

  @api
  Scenario: Video
    Given I am an anonymous user
    Given I am viewing a video with the title "Here is a video"
    Then the response should contain "<link rel=\"canonical\" href=\"/videos/here-video\" />"
  


