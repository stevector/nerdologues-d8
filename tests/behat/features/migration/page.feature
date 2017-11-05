Feature: Page

  @api
  Scenario: Page nodes
    Given I log in as an administrator
    When I visit "admin/content-migration/page"
    Then I should see the following table portion
    | Title                                                 | Content type | URI                                                                 | Blog tags  |
    | Fisticuffs! Rules                                     | Basic page   |                                                                     | Fisticuffs |
    | Fisticuffs! FAQ                                       | Basic page   | public://field_image/page/Screen Shot 2015-08-28 at 10.39.04 AM.png | Fisticuffs |
    | Fisticuffs!                                           | Basic page   |                                                                     | Fisticuffs |
    | Honorary member description - used on /nerds          | Basic page   |                                                                     |            |
    | Event body - body field used on /events               | Basic page   |                                                                     |            |
    | Video body - body field used on /video                | Basic page   |                                                                     |            |
    | Emeritus member description - Body used on /nerds     | Basic page   |                                                                     |            |
    | Nerd current member description - Body used on /nerds | Basic page   |                                                                     |            |
    | Podcast page - Body used on /podcasts                 | Basic page   |                                                                     |            |
    | Nerds are funny                                       | Basic page   | public://field_image/page/playground-alley.jpg                      |            |
