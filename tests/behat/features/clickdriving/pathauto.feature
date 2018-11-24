Feature: Pathauto

  @api
  Scenario: blog post
    Given I log in as a content_administrator
    When I visit "node/add/blog_post"
    And I fill in "title[0][value]" with "A Blog Post Title"
    And I fill in "field_date_published[0][value][date]" with "2015-10-31"
    And I fill in "field_date_published[0][value][time]" with "15:05:05"
    And I check the box "Publishing status"
    And I press "Save"
    Then the response should contain "<link rel=\"canonical\" href=\"/blog/2015-10-31/blog-post-title\" />"

  @api
    Scenario: Podcast, Podcast Episode, and clip
    Given I log in as a content_administrator
    Given I make and view a podcast with the title "Someone's best podcast"
    Then the response should contain "<link rel=\"canonical\" href=\"/podcasts/someones-best-podcast\" />"

    # PODCAST EPISODE
    Given I log in as a content_administrator
    When I visit "node/add/podcast_episode"
    And I fill in "title[0][value]" with "That one pod episode"
    And I select the radio button "Someone's best podcast"
    And I check the box "Publishing status"
    And I press "Save"
    Then the response should contain "<link rel=\"canonical\" href=\"/podcasts/someones-best-podcast/episodes/one-pod-episode\" />"

    # CLIP
    When I visit "node/add/clip"
    And I fill in "title[0][value]" with "A cool Clip of a story"
    And I select the radio button "Someone's best podcast"
    And I fill in "field_ref_podcast_episode[0][target_id]" with "That one pod episode"
    And I check the box "Publishing status"
    And I press "Save"
    Then the response should contain "<link rel=\"canonical\" href=\"/podcasts/someones-best-podcast/clips/cool-clip-story\" />"

  @api
  Scenario: Basic page
    Given I log in as a content_administrator
    Given I make and view a page with the title "Some Random Basic Page"
    Then the response should contain "<link rel=\"canonical\" href=\"/some-random-basic-page\" />"

  @api
  Scenario: People
    Given I log in as a content_administrator
    # And a "member_designations" term with the name "Viewable bio page"
    When I visit "node/add/person"
    And I fill in "title[0][value]" with "Another person"
    And I check the box "Viewable bio page"
    And I check the box "Published"
    And I press "Save"
    Then the response should contain "<link rel=\"canonical\" href=\"/nerds/another-person\" />"

  @api
  Scenario: location
    Given I log in as a content_administrator
    Given I am viewing a location with the title "A theatre test"
    Given I am an anonymous user
    Then the response should contain "<link rel=\"canonical\" href=\"/locations/theatre-test\" />"

# Events are made to redirect to external pages so I'm not concerned with their pathauto settings.
#  @api
#  Scenario: event
#    Given I am an anonymous user
#    Given I am viewing a event with the title "Your Stories November"
#    Then the response should contain "<link rel=\"canonical\" href=\"/events/your-stories-november\" />"

  @api
  Scenario: Video
    Given I log in as a content_administrator
    When I make and view a video with the title "Here is a video"
    Then the response should contain "<link rel=\"canonical\" href=\"/videos/here-video\" />"
