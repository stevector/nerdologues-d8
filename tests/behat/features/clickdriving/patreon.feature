Feature: Patreon

  @api @current
  Scenario: A. Manually entered Patreon link text
    Given I log in as a content_administrator
    When I make an old episode
    And I fill in "field_link_paywall_content[0][uri]" with "http://yahoo.com"
    And I fill in "field_link_paywall_content[0][title]" with ""
    And I press "Save"
    And print current URL
    Then I should see "Support us on Patreon to get MP3 access"
    Then I should not see "Download mp3"

  @api
  Scenario: A2. Default Patreon Link text
    Given I log in as a content_administrator
    When I make an old episode
    And I fill in "field_link_paywall_content[0][uri]" with "http://yahoo.com"
    And I fill in "field_link_paywall_content[0][title]" with ""
    And I press "Save"
    Then I should see "Support us on Patreon to listen to the full episode!"
    Then I should not see "Download mp3"
    When I visit the podcast feed
    Then the response should not contain "Episode 23"


# @todo, find the gitsubmmodule that was accidentally committed.

  @api
  Scenario: B. No Patreon Link at all. Old episode
    Given I log in as a content_administrator
    When I make an old episode
    And I fill in "field_link_paywall_content[0][uri]" with ""
    And I fill in "field_link_paywall_content[0][title]" with ""
    And I press "Save"
    Then I should not see "Support us on Patreon to listen to the full episode!"
    Then I should see "Download mp3"
    When I visit the podcast feed
    Then the response should contain "Episode 23"

  @api
  Scenario: C. No Patreon link for recent episodes but with Patreon info entered
    Given I log in as a content_administrator
    When I make an new episode episode
    And I fill in "field_link_paywall_content[0][uri]" with "http://yahoo.com"
    And I fill in "field_link_paywall_content[0][title]" with ""
      # @todo, this test is bad in that I'm hard coding a date and the Patreon default text.
      # I should write a custom context to create the input date.
    And I fill in "field_date_published[und][0][value][date]" with "2016-03-24"
    And I press "Save"
    Then I should not see "Support us on Patreon to listen to the full episode!"
    Then I should see "Download mp3"
    When I visit the podcast feed
    Then the response should contain "Episode 23"


  @api
  Scenario: D. No Patreon Link at all. New episode
    Given I log in as a content_administrator
    When I make an old episode
    And I fill in "field_link_paywall_content[0][uri]" with ""
    And I fill in "field_link_paywall_content[0][title]" with ""
    And I press "Save"
    Then I should not see "Support us on Patreon to listen to the full episode!"
    Then I should see "Download mp3"
    When I visit the podcast feed
    Then the response should contain "Episode 23"
