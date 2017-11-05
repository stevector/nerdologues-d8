Feature: Video

  @api
  Scenario: Video nodes table
    Given I log in as an administrator
    When I visit "admin/content-migration/video"
    Then I should see the following table portion
    | Kay Liston Reviews the World - Cat Sweater | https://www.youtube.com/watch?v=5OUSsxXkUdk | Joe Gennaro, Claire Friedman, Mary Beth Smith | 2014-02-13 |
    Then I should see the following table portion
    | Repossessed | https://www.youtube.com/watch?v=dn8p_m5wcYo | Chris Geiger, Michael Jando, Steve Persch, Kevin Reader | 2014-01-30 |
    Then I should see the following table portion
    | Intro to "Fisticuffs!" - an Instructional Video | https://www.youtube.com/watch?v=22DlIjcieJc | Chris Geiger | 2016-02-08 |
