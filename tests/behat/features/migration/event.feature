Feature: Events

  @api
  Scenario: Event nodes
    Given I am logged in as a user with the "administrator" role
    When I visit "admin/content-migration/event"
    Then I should see the following table portion
      
| Title                                                                                | Content type | Location                              |
| SATURDAY / saturday                                                                  | Event        | iO Chicago (Wrigleyville)             |
| Superhero Bar Crawl                                                                  | Event        |                                       |
| The Skywalking Dead                                                                  | Event        | The Playground Theater                |
| Your Stories: Coming Home                                                            | Event        | Upstairs Gallery                      |
| Werewolf (Game Night)                                                                | Event        | Fizz Bar / Pub Theater                |
| New York Comic Con                                                                   | Event        | Javits Center                         |
| Your Stories: End of the World                                                       | Event        | Upstairs Gallery                      |
| Your Stories: Propose a Theory                                                       | Event        | Upstairs Gallery                      |
| Your Stories: Sport                                                                  | Event        | Upstairs Gallery                      |
| New York City Sketch Festival                                                        | Event        | The PIT                               |
| The Nerdologues Present                                                              | Event        | iO Chicago (Wrigleyville)             |
| Kokomocon                                                                            | Event        |                                       |
| Halloween at the PLAYGROUND                                                          | Event        | The Playground Theater                |
| Poe: Improvised Tales of the Macabre                                                 | Event        | The Playground Theater                |
| The Nerdologues Present: November Edition                                            | Event        | iO Chicago (Wrigleyville)             |
| Your Stories - November: Annual                                                      | Event        | Upstairs Gallery                      |
| Who Got Glitter on My Controller?                                                    | Event        | Fizz Bar / Pub Theater                |
| The Nerdologues Present: Nerd Wars Holiday Special                                   | Event        | iO Chicago (Wrigleyville)             |
| Your Stories - December - Potpourri                                                  | Event        | Upstairs Gallery                      |
| The Chicago Sketch Comedy Festival                                                   | Event        |                                       |
| Your Stories - January - New Beginnings                                              | Event        |                                       |
| Nerds Against Humanity                                                               | Event        | iO Chicago (Wrigleyville)             |
| Your Stories - Fan Fiction February                                                  | Event        | The Public House Theatre              |
| Nerds Against Humanity                                                               | Event        |                                       |
| Game Night: Werewolf                                                                 | Event        | The Public House Theatre              |
| March of Madness                                                                     | Event        | The Public House Theatre              |
| March Game Night: Werewolf                                                           | Event        | The Public House Theatre              |
| Your Stories: March - It's a Mad World                                               | Event        | The Public House Theatre              |
| Fan Fiction Live!                                                                    | Event        | iO Chicago (Wrigleyville)             |
| We're All Gonna Live Forever                                                         | Event        | The Public House Theatre              |
| First Contact Countdown                                                              | Event        | The Public House Theatre              |
| Your Stories: Crime and Punishment                                                   | Event        | The Public House Theatre              |
| C2E2 After Party                                                                     | Event        | The Public House Theatre              |
| C2E2                                                                                 | Event        |                                       |
| Cinco De Bilbo                                                                       | Event        | The Public House Theatre              |
| The Uncanny Sex-Men & The Rise of The Nude Gods                                      | Event        | The Public House Theatre              |
| Nerd Comedy Festival                                                                 | Event        | Stage 773                             |
| Your Stories: Journey                                                                | Event        | The Public House Theatre              |
| The Dweebutante Ball                                                                 | Event        | The Public House Theatre              |
| The Nerdologues Present: JJ Abrams Presents The Nerdologues                          | Event        | The Public House Theatre              |
| Your Stories - June - Indie                                                          | Event        | The Public House Theatre              |
| The Nerdologues and Chicago Loot Drop Present: NERDRIFF Superman the Movie           | Event        | The Public House Theatre              |
| Sayonara Alex Talavera                                                               | Event        | The Public House Theatre              |
| Your Stories: Best-Laid Plans                                                        | Event        | The Public House Theatre              |
| Cards Against Humanity Live                                                          | Event        | The Triple Door                       |
| The Nerdologues Presents: 1993!                                                      | Event        | The Public House Theatre              |
| Your Stories: September - "1993"                                                     | Event        | The Public House Theatre              |
| The Nerdologues Presents: Screw These Guys, AMIRITE?!                                | Event        | The Public House Theatre              |
| The Nerdologues Presents: Your Stories - "Other Options"                             | Event        | The Public House Theatre              |
| The Nerdologues Presents: Your Stories - Across The Universe (with special guests!)  | Event        | The Public House Theatre              |
| The Nerdologues Presents: The Multiverse vs. George Lucas                            | Event        | The Public House Theatre              |
| The Nerdologues Trivia Party! Beat the Nerds (not literally)                         | Event        | The Public House Theatre              |
| The Nerdologues Presents Your Stories: Annual 2 (with Plan 9 Burlesque!)             | Event        | The Public House Theatre              |
| The Nerdologuecast Live!                                                             | Event        | The Public House Theatre              |
| Your Stories end of year nominations due                                             | Event        |                                       |
| The Chicago Sketch Comedy Festival                                                   | Event        | Stage 773                             |
| Holiday Bullshit                                                                     | Event        |                                       |
| Your Stories - Full Hearts                                                           | Event        | The Public House Theatre              |
| LOL Chicago Comedy Magic Draft                                                       | Event        | The Public House Theatre              |
| Your Stories - Fan Fiction February 2                                                | Event        | The Public House Theatre              |
| Chicago Nerd Comedy Festival                                                         | Event        | Stage 773                             |
| Nerdologues Game Night: The Leonard Maltin Game!                                     | Event        | The Public House Theatre              |
| The Nerdologues' Your Stories - SCARRED featuring The Chicago Outfit Roller Derby    | Event        | The Public House Theatre              |
| Your Stories @ The Chicago Nerd Comedy Fest! - "After Dark"                          | Event        | Stage 773                             |
| Your Stories - The Truth (Is Out There)                                              | Event        | The Public House Theatre              |
| Nerdologues Game Night: Superhero Edition!                                           | Event        | The Public House Theatre              |
| May The Fourth: A Star Wars Celebration                                              | Event        | The Public House Theatre              |
| The Lord of the The Wrigley: The Fellowship of The Cubs                              | Event        | The Public House Theatre              |
| Your Stories at C2E2                                                                 | Event        |                                       |
| Game Night - "Magic: The Gathering" - Journey Into Nyx                               | Event        | The Public House Theatre              |
| Your Stories: Fellowship featuring CAKE                                              | Event        | The Public House Theatre              |
| Your Stories: "Circus" featuring Upstairs Gallery                                    | Event        | The Public House Theatre              |
| A Jangleheart Circus                                                                 | Event        | The Den Theatre                       |
| Your Stories: "Fingers Crossed"                                                      | Event        | The Public House Theatre              |
| 4 More Years! (A 4 year Anniversary Party)                                           | Event        | The Public House Theatre              |
| Your Stories: "Bottoms Up" featuring Geek Bar Chicago!                               | Event        | The Public House Theatre              |
| Cards Against Humanity Presents: The Doubleclicks and The Nerdologues                | Event        | The Public House Theatre              |
| Cards Against Humanity And Friends                                                   | Event        | The Triple Door                       |
| Your Stories: My Lips Are Sealed featuring Elliott Serrano and Space Happens!        | Event        | The Public House Theatre              |
| Your Stories: "Heartland" featuring Midwest Action AT BLACK ROCK PUB                 | Event        | Black Rock Pub & Kitchen              |
| Your Stories: APOCALYPSE featuring I Fight Dragons & Our Fair City                   | Event        | The Public House Theatre              |
| Alpha                                                                                | Event        | The Logan Theatre                     |
| DRINKS-Giving                                                                        | Event        | The Playground Theater                |
| Your Stories: Annual #3                                                              | Event        | The Public House Theatre              |
| Your Stories @ the Midwinter Gaming Convention!                                      | Event        | Hilton Downtown Milwaukee City Center |
| The 2015 Chicago Sketch Comedy Festival                                              | Event        | Stage 773                             |
| Your Stories: "House Rules" featuring the House Theatre!                             | Event        | The Public House Theatre              |
| Opening for Improvised Star Trek                                                     | Event        | iO Chicago                            |
| The Nerdologues take Los Angeles                                                     | Event        | UCB Sunset                            |
| Your Stories: Fanfiction February Three at THREADLESS HQ!                            | Event        | Threadless HQ                         |
| Your Stories: "Pick a Card" with special guests/our new home Cards Against Humanity! | Event        | Some Office                           |
| Your Stories: "Press Start" with Arcade Brewery & Other Great Guests!                | Event        | Some Office                           |
| CG2 2015 Kick-Off Party                                                              | Event        |                                       |
| MBSing Live: 100th Episode Recording                                                 | Event        | Some Office                           |
| Your Stories: "Sound Idea" with the Chicago Podcast Coop!                            | Event        | Some Office                           |
| The Nerdologues Presents Your Stories Chicago Design Week Edition!                   | Event        | Some Office                           |
| Fisticuffs! Launch Party                                                             | Event        | Some Office                           |
| Fisticuffs! Kickstarter - Successfully funded!                                       | Event        |                                       |
| High Five Party                                                                      | Event        | Some Office                           |
| 'Your Stories' at Adler After Dark!                                                  | Event        | Adler Planetarium                     |
| Your Stories: "Fans" with Mark Colomb and Friends!                                   | Event        | Some Office                           |
| Your Stories: "Authentic" with Shawn Smith and Friends!                              | Event        | Some Office                           |
| PAX to the MAX!                                                                      | Event        |                                       |
| Chicago Southland Mini Maker Faire                                                   | Event        |                                       |
| Fisticuffs! Pickup Party and BONUS Show                                              | Event        | Some Office                           |
| Your Stories - "Kids Again" featuring Peaches & Hot Sauce!                           | Event        | Some Office                           |
| The Nerdologues Do Pittsburgh                                                        | Event        | The Arcade Comedy Theatre             |
| The Nerdologues Do Pittsburgh                                                        | Event        |                                       |
| Your Stories Live - "Horror Stories" featuring the Match 3 Podcast!                  | Event        | Some Office                           |
| Your Stories -- "A Night with the Stars" featuring Improvised Star Trek!             | Event        | Some Office                           |
| The Nerd Wars Holiday Special II                                                     | Event        | Some Office                           |
| Your Stories: Annual 4                                                               | Event        | Some Office                           |
| Your Stories: "Character Generation" with the One Shot/Campaign podcasts!            | Event        | Some Office                           |
| Your Stories with the Chicago Design Museum                                          | Event        | Chicago Design Museum                 |
| Your Stories: Fanfiction 4 featuring the Masters of the Universe                     | Event        | Some Office                           |
| Your Stories: "THanks" w/ Tom Hanks Day (at Begyle Brewing)!                         | Event        | Begyle Brewing                        |
