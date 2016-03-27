Feature: Content
  In order to test some basic Behat functionality
  As a website user
  I need to be able to see that the Drupal and Drush drivers are working

  @api
  Scenario: Manually entered Patreon link text
    Given I am logged in as a user with the "administrator" role
    When I visit "node/1424/edit"
    And I fill in "field_link_paywall_content[und][0][url]" with "http://yahoo.com"
    And I fill in "field_link_paywall_content[und][0][title]" with "Support us on Patreon to get MP3 access"
    And I press "Save"
    Then I should see "Support us on Patreon to get MP3 access"
    Then I should not see "Download mp3"
