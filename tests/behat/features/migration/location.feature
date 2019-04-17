Feature: Page

  @api
  Scenario: Location nodes
    Given I log in as an administrator
    When I visit "admin/content-migration/location"
    Then I should see the following table portion
      | Title                                 | Content type | Address                                                 |
      | Upstairs Gallery                      | Location     | 5219 N Clark Chicago, IL United States                  |
      | The Playground Theater                | Location     | 3209 N Halsted Chicago, IL United States                |
      | iO Chicago (Wrigleyville)             | Location     | 3541 N. Clark St Chicago, IL United States              |
      | Fizz Bar / Pub Theater                | Location     | 3220 N Lincoln Ave Chicago, IL United States            |
      | Javits Center                         | Location     | 655 West 34th Street New York, NY United States         |
      | The PIT                               | Location     | 123 E 24th Street New York, NY United States            |
      | The Public House Theatre              | Location     | 3914 N Clark Chicago, IL 60613 United States            |
      | Stage 773                             | Location     | 1225 W. Belmont Chicago, IL United States               |
      | The Triple Door                       | Location     | 216 Union Street Seattle, WA 98101 United States        |
      | The Den Theatre                       | Location     | 1333 N. Milwaukee Ave Chicago, IL 60622 United States   |
      | Black Rock Pub & Kitchen              | Location     | 3614 N Damen Ave Chicago, IL 60618 United States        |
      | The Logan Theatre                     | Location     | 2646 N Milwaukee Ave Chicago, IL 60647 United States    |
      | Hilton Downtown Milwaukee City Center | Location     | 509 W Wisconsin Ave Milwaukee, WI 53203 United States   |
      | iO Chicago                            | Location     | 1501 N Kingsbury St Chicago, IL 60642 United States     |
      | UCB Sunset                            | Location     | 5419 W Sunset Blvd Los Angeles, CA 90027 United States  |
      | Threadless HQ                         | Location     | 1260 W Madison St Chicago, IL 60607 United States       |
      | Cards Against Humanity Theater        | Location     | 1551 W Homer St Chicago, IL 60642 United States         |
      | Adler Planetarium                     | Location     | 1300 S Lake Shore Drive Chicago, IL 60605 United States |
      | The Arcade Comedy Theatre             | Location     | 811 Liberty Ave Pittsburgh, PA 15222 United States      |
      | Chicago Design Museum                 | Location     | 108 N State St, Fl 3rd Chicago, IL 60602 United States  |
      | Begyle Brewing                        | Location     | 1800 W Cuyler Ave Chicago, IL 60613 United States       |
      | Harold Washington Library             | Location     | 400 S State St Chicago, IL 60605 United States          |
      | Chicago Cultural Center               | Location     | 78 E Washington St Chicago, IL 60602 United States      |
      | The Voodoo Comedy Playhouse           | Location     | 1260 22nd Street Denver, CO 80205 United States         |
      | 230 W. Huron St                       | Location     | 230 W. Huron St Chicago, IL 60654 United States         |
      | The Hideout                           | Location     | 1354 W Wabansia Ave Chicago, IL 60642 United States     |
      | The 1700 Theatre at Steppenwolf       | Location     | 1700 N Halsted Chicago, IL 60614 United States          |
      | UCB Franklin                          | Location     | 5919 Franklin Ave Los Angeles, CA 90028 United States   |
      | Nerdmelt Showroom at Meltdown Comics  | Location     | 7522 Sunset Blvd Los Angeles, CA 90046 United States    |
      | Wayward Coffeehouse                   | Location     | 6417 Roosevelt Way NE Seattle, WA 98115 United States   |
      | The Knockout                          | Location     | 3223 Mission St San Francisco, CA 94110 United States   |
      | Nomad World Pub                       | Location     | 501 Cedar Ave S Minneapolis, MN 55454 United States     |
      | The Beat Kitchen                      | Location     | 2100 W Belmont Ave Chicago, IL 60618 United States      |
      | 826CHI                                | Location     | 1276 N Milwaukee Ave Chicago, IL 60622 United States    |
      | Challengers Comics                    | Location     | 1845 N Western Ave Chicago, IL 60647 United States      |
      | American Writers Museum               | Location     | 180 N Michigan Ave Chicago, IL 60601 United States      |
