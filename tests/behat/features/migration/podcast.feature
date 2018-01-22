Feature: Podcast

  @api @current
  Scenario: Podcast nodes
    Given I log in as an administrator
    When I visit "admin/content-migration/podcast"
    Then I should see the following table portion
      | Title                                 | Content type | URI                                                            |
      | Your Stories                          | Podcast      | public://field_image/podcast/Nerdologues-2017-refresh-13_0.jpg |
      | MBSing                                | Podcast      | public://field_image/podcast/Nerdologues-2017-refresh-16.png   |
      | The Nerdologuecast                    | Podcast      | public://field_image/podcast/Nerdologues-2017-refresh-15.png   |
      | Talking Games                         | Podcast      | public://field_image/podcast/Nerdologues-2017-refresh-14.png   |
      | Poor Choices Archive                  | Podcast      | public://field_image/podcast/newsmallposter_0.jpg              |
      | The Ketchup                           | Podcast      | public://field_image/podcast/Ketchupbig.jpg                    |
      | Sports Retorts with Hooli and The Joe | Podcast      | public://field_image/podcast/SportsRetorts_1400x1400_Rev1.png  |
      | Blank Cassette                        | Podcast      | public://field_image/podcast/bclogo.jpg                        |
      | Let's Get It On                       | Podcast      | public://field_image/podcast/LGIO alt logo pwy.jpg             |
