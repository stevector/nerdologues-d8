Feature: Date list
  In order to control the promotion of content
  As a content creator
  Nodes with published dates in the future should not appear on listings.

  @api
  Scenario: Close future date
    Given I am logged in as a user with the "content_administrator" role
    When I create a video with a published date in the future
    Then that video does not appear on the video page
    # @todo
    # And that video does not appear the homepage "Nerds Online" section.

  @api
  Scenario: Close past date
    Given I am logged in as a user with the "content_administrator" role
    When I create a video with a published date in the past
    Then that video appears on the video page
    # @todo
    # And it appears on the homepage "Nerds Online" section.
