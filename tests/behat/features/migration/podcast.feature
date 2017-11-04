Feature: Podcast

  @api
  Scenario: Podcast nodes
    Given I am logged in as a user with the "administrator" role
    When I visit "admin/content-migration/podcast"
    Then I should see the following table portion
      | Title                                 | Content type | URI                                                           |
      | Let's Get It On                       | Podcast      | public://field_image/podcast/LGIO alt logo pwy.jpg            |
      | Blank Cassette                        | Podcast      | public://field_image/podcast/blankcassette_final.jpg          |
      | Sports Retorts with Hooli and The Joe | Podcast      | public://field_image/podcast/SportsRetorts_1400x1400_Rev1.png |
      | The Ketchup                           | Podcast      | public://field_image/podcast/Ketchupbig.jpg                   |
      | Poor Choices Archive                  | Podcast      | public://field_image/podcast/newsmallposter_0.jpg             |
      | Talking Games                         | Podcast      | public://field_image/podcast/Nerdologues-2017-refresh-14.png  |
      | The Nerdologuecast                    | Podcast      | public://field_image/podcast/Nerdologues-2017-refresh-15.png  |
      | MBSing                                | Podcast      | public://field_image/podcast/Nerdologues-2017-refresh-16.png  |
      | Your Stories                          | Podcast      | public://field_image/podcast/TourStories.png                  |
