Feature: Podcast Episode

  @api
  Scenario: Podcast Episode
    Given I am logged in as a user with the "administrator" role
    When I visit "admin/content-migration/podcast_episode"
    Then I should see the following table portion
    |Chris Geiger | Person | Current Member, Founding Member, Viewable bio page | public://geiger-square.png | public://geiger-square.png | Geiger |
