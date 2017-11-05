Feature: Alias Generation
  This is not so much a test as it is a janky migration.
  This feature is meant to be run once to generate real aliases.

  @api
  Scenario: Bio without proper term does not appear on the nerd page.
    Given I log in as an administrator
    When I visit "admin/config/search/path/add"
    And I fill in "Existing system path" with "/node/81/clips"
    And I fill in "Path alias" with "/podcasts/your-stories/clips"
    And I press "Save"
    And I visit "/podcasts/your-stories/clips"
    Then I should see "Your Stories: Clip Archive"
    Then the following aliases are created and valid
    | Existing system path | Path alias                                        | Expected text                                          |
    | /node/81/episodes    | /podcasts/your-stories/episodes                   | Episode Archive: Your Stories                          |
    | /node/82/episodes    | /podcasts/mbsing/episodes                         | Episode Archive: MBSing                                |
    | /node/83/episodes    | /podcasts/nerdologuecast/episodes                 | Episode Archive: The Nerdologuecast                    |
    | /node/700/episodes   | /podcasts/talking-games/episodes                  | Episode Archive: Talking Games                         |
    | /node/1041/episodes  | /podcasts/poor-choices/episodes                   | Episode Archive: Poor Choices                          |
    | /node/1894/episodes  | /podcasts/ketchup/episodes                        | Episode Archive: The Ketchup                           |
    | /node/2199/episodes  | /podcasts/sports-retorts-hooli-and-joe/episodes   | Episode Archive: Sports Retorts with Hooli and The Joe |
    | /node/2621/episodes  | /podcasts/blank-cassette/episodes                 | Episode Archive: Blank Cassette                        |

#  @todo https://github.com/stevector/nerdologues-d8/issues/183
# node/81/feed	podcasts/your-stories/feed
# node/82/feed	podcasts/mbsing/feed
# node/83/feed	podcasts/nerdologuecast/feed
# node/700/feed	podcasts/talking-games/feed
# node/1041/feed	podcasts/poor-choices/feed
# node/1894/feed	podcasts/ketchup/feed
# node/2199/feed	podcasts/sports-retorts-hooli-and-joe/feed
# node/2621/feed	podcasts/blank-cassette/feed
