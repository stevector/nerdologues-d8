Feature: Date list
  In order to control the promotion of content
  As a content creator
  Nodes with published dates in the future should not appear on listings.

  @api
  Scenario: Close future date
    Given I log in as a content_administrator
    # A video in the past is needed too, otherwise the Nerds Online section won't exist at all.
    And I create a video with a published date in the past
    When I create a video with a published date in the future
    Then that video does not appear on the video page
    And it does not appear the homepage "Nerds Online" region.

  @api
  Scenario: Close past date
    Given I log in as a content_administrator
    When I create a video with a published date in the past
    Then that video appears on the video page
    And it appears on the homepage "Nerds Online" region.
