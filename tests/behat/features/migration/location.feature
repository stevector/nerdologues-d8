Feature: Page

  @api
  Scenario: Location nodes
    Given I log in as an administrator
    When I visit "admin/content-migration/location"
    Then I should see the following table portion
      | Title                                 | Content type | Address                                               |
      | Upstairs Gallery                      | Location     | 5219 N ClarkChicago, ILUnited States                  |
      | The Playground Theater                | Location     | 3209 N HalstedChicago, ILUnited States                |
      | iO Chicago (Wrigleyville)             | Location     | 3541 N. Clark StChicago, ILUnited States              |
      | Fizz Bar / Pub Theater                | Location     | 3220 N Lincoln AveChicago, ILUnited States            |
      | Javits Center                         | Location     | 655 West 34th StreetNew York, NYUnited States         |
      | The PIT                               | Location     | 123 E 24th StreetNew York, NYUnited States            |
      | The Public House Theatre              | Location     | 3914 N ClarkChicago, IL 60613United States            |
      | Stage 773                             | Location     | 1225 W. BelmontChicago, ILUnited States               |
      | The Triple Door                       | Location     | 216 Union StreetSeattle, WA 98101United States        |
      | The Den Theatre                       | Location     | 1333 N. Milwaukee AveChicago, IL 60622United States   |
      | Black Rock Pub & Kitchen              | Location     | 3614 N Damen AveChicago, IL 60618United States        |
      | The Logan Theatre                     | Location     | 2646 N Milwaukee AveChicago, IL 60647United States    |
      | Hilton Downtown Milwaukee City Center | Location     | 509 W Wisconsin AveMilwaukee, WI 53203United States   |
      | iO Chicago                            | Location     | 1501 N Kingsbury StChicago, IL 60642United States     |
      | UCB Sunset                            | Location     | 5419 W Sunset BlvdLos Angeles, CA 90027United States  |
      | Threadless HQ                         | Location     | 1260 W Madison StChicago, IL 60607United States       |
      | Some Office                           | Location     | 1917 N Elston AveChicago, ILUnited States             |
      | Adler Planetarium                     | Location     | 1300 S Lake Shore DriveChicago, IL 60605United States |
      | The Arcade Comedy Theatre             | Location     | 811 Liberty Ave Pittsburgh, PA 15222United States     |
      | Chicago Design Museum                 | Location     | 108 N State St, Fl 3rdChicago, IL 60602United States  |
      | Begyle Brewing                        | Location     | 1800 W Cuyler AveChicago, IL 60613United States       |
