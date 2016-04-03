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
    #Then print last response
    #And I break
    Then the response should contain "<link rel=\"canonical\" href=\"/blog/2015-10-31/a-blog-post-title\" />"
                                 


  @api
    Scenario: Podcast, Podcast Episode, and clip
    Given I am an anonymous user
    Given I am viewing a podcast with the title "Someone's cool podcast"
    Then the response should contain "<link rel=\"canonical\" href=\"/podcasts/someone-s-cool-podcast\" />"

    # @todo role   
    Given I am logged in as a user with the "administrator" role
    When I visit "node/add/podcast_episode"
    And I fill in "title[0][value]" with "A podcast episode"
   # And I break    
    And I select the radio button "Someone's cool podcast"
    And I press "Save and publish"
    Then print last response
    Then the response should contain "<link rel=\"canonical\" href=\"/podcasts/someone-s-cool-podcast/episodes/a-podcast-episode\" />"



    When I visit "node/add/clip"
    And I fill in "title[0][value]" with "A Clip"
    # And I break
    And I select the radio button "Someone's cool podcast"
    And I fill in "field_ref_podcast_episode[0][target_id]" with "A podcast episode"
    And I press "Save and publish"
    Then print last response
    Then the response should contain "<link rel=\"canonical\" href=\"/podcasts/someone-s-cool-podcast/clips/a-clip\" />"







  
  @api
  Scenario: Basic page
    Given I am an anonymous user
    Given I am viewing a page with the title "Some Random Basic Page"
    #Then print last response
    Then the response should contain "<link rel=\"canonical\" href=\"/some-random-basic-page\" />"





  