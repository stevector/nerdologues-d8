Feature: Podcast feeds

  @api
  Scenario: Podcast feed
    When I visit "podcasts/yourstories/feed"
    Then the output matches the XML of "podcasts/yourstories/feed" on the Drupal 7 site.
