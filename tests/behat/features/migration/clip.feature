Feature: Clip

  @api
  Scenario: Clip
    Given I am logged in as a user with the "administrator" role
    When I visit "admin/content-migration/clip?order=field_date_published&sort=desc"
    Then I should see the following table portion
      | Title                                                                                                                                     | Podcast      | Authors                                                                      | End Time | Start Time | episode                                                                                | Date Published Sort ascending |
      | Andrew Bentley: Role Models                                                                                                               | Your Stories | Andrew Bentley                                                               | 1033     | 695        | November 2012 Part 1: The Sporting Life                                                | 2015-09-01                    |
      | Eric Garneau: Call to Adventure                                                                                                           | Your Stories | Eric Garneau                                                                 | 2380     | 2222       | June 2013: Journey, Part 2                                                             | 2015-08-25                    |
      | Dwight & Eric: Land of Confusion                                                                                                          | Your Stories | Dwight Haesler, Eric Garneau                                                 | 521      | 240        | August 2012 Part 2: Land of Confusion                                                  | 2015-08-18                    |
      | Nerdologues: Magneto Was Right                                                                                                            | Your Stories | Bill Kenkel, Steve Persch                                                    | 560      | 341        | BONUS Episode: Live at Challengers Comics!                                             | 2015-08-04                    |
      | Allison MacWilliams-Brooks: My Dad & Star Trek                                                                                            | Your Stories | Allison MacWilliams-Brooks                                                   | 800      | 352        | June 2013: Journey, Part 2                                                             | 2015-07-28                    |
      | Katie Johnston-Smith: Mad                                                                                                                 | Your Stories | Katie Johnston-Smith                                                         | 3174     | 2968       | May 2015: Press Start, Part 1                                                          | 2015-06-23                    |
      | Kevin Reader & Chris Geiger: Dungeons & Dragons slam poetry                                                                               | Your Stories | Kevin Reader, Chris Geiger                                                   | 1148     | 1018       | BONUS: Live at Project Comic-Con, St. Louis                                            | 2015-06-02                    |
      | Mary Beth Smith: Helping                                                                                                                  | Your Stories | Mary Beth Smith                                                              | 757      | 362        | December 2013: Across the Universe, Part 2                                             | 2015-05-26                    |
      | Mary Beth Smith: Flight                                                                                                                   | Your Stories | Mary Beth Smith                                                              | 602      | 371        | April 2014: Scarred, Part 1                                                            | 2015-04-28                    |
      | Chris Geiger: Gotta Catch ‘Em All                                                                                                         | Your Stories | Chris Geiger                                                                 | 2707     | 2326       | November 2012 Part 1: The Sporting Life                                                | 2015-04-13                    |
      | Cover Stories: Alone                                                                                                                      | Your Stories | Claire Friedman, Dwight Haesler, Eric Garneau                                | 620      | 382        | February 2014: Full Hearts, Part 1                                                     | 2015-03-31                    |
      | Bill Kenkel: On Sexuality and Productivity                                                                                                | Your Stories | Bill Kenkel                                                                  | 3040     | 2723       | May 2012 Part 1: Let’s Talk About Sex                                                  | 2015-03-24                    |
      | Chris Crotwell: Discovering an Author                                                                                                     | Your Stories | Chris Crotwell                                                               | 2411     | 1987       | February 2013 Part 1: A New Hope                                                       | 2015-03-17                    |
      | Chris Geiger: Ode to Will Riker                                                                                                           | Your Stories | Chris Geiger                                                                 | 1060     | 621        | February 2014: Full Hearts, Part 1                                                     | 2015-03-10                    |
      | Mary Beth Smith: This Year                                                                                                                | Your Stories | Mary Beth Smith                                                              | 1076     | 735        | January 2014: Annual 2, Part 2                                                         | 2015-03-03                    |
      | Joe Gennaro: 9-to-5er                                                                                                                     | Your Stories | Joe Gennaro                                                                  | 1216     | 760        | November 2013: Other Options, Part 1                                                   | 2015-02-17                    |
      | Claire, Dwight, & Eric: Rebel Yell                                                                                                        | Your Stories | Eric Garneau, Claire Friedman, Dwight Haesler                                | 467      | 162        | November 2013: Other Options, Part 2                                                   | 2015-02-09                    |
      | Katie Johnston-Smith: Titanic                                                                                                             | Your Stories | Katie Johnston-Smith                                                         | 1334     | 1151       | September 2014 Bonus: Under the Sea Live from the Jangleheart Circus                   | 2015-01-26                    |
      | Chris Geiger: Why We Need the Man of Steel                                                                                                | Your Stories | Chris Geiger                                                                 | 917      | 563        | July 2013 Bonus: Superman                                                              | 2014-04-04                    |
      | Dwight, Eric & Claire: Zombie                                                                                                             | Your Stories | Dwight Haesler, Eric Garneau, Claire Friedman                                | 2684     | 2426       | August 2012 Part 2: Land of Confusion                                                  | 2014-03-14                    |
      | Steve Persch: Left Behind                                                                                                                 | Your Stories | Steve Persch                                                                 | 3435     | 3101       | March 2012 - The Music of Our Nerdy Hearts                                             | 2014-03-06                    |
      | Mary Zee: The Best Present I Ever Gave / She Saved the World a Lot                                                                        | Your Stories | Mary Zee                                                                     | 2104     | 1379       | January 2014: Annual 2, Part 1                                                         | 2014-02-27                    |
      | Dwight & Eric: The Pokémon Theme                                                                                                          | Your Stories | Dwight Haesler, Eric Garneau                                                 | 2772     | 2707       | November 2012 Part 1: The Sporting Life                                                | 2014-02-20                    |
      | Kevin Reader: Bad Reviews                                                                                                                 | Your Stories | Kevin Reader, Alex Talavera                                                  | 993      | 606        | January 2012                                                                           | 2014-02-13                    |
      | Cover Stories w/ the Nerdologues Chorus: Be Prepared                                                                                      | Your Stories | Dwight Haesler, Claire Friedman, Eric Garneau, Steve Persch, Mary Beth Smith | 385      | 150        | April 2014: Scarred, Part 2                                                            |                               |
      | Joseph Walker - One World by Night                                                                                                        | Your Stories | Joseph Walker                                                                | 1022     | 533        | April/May 2014 Bonus: Conventionally Speaking live at C2E2 with Team StarKid and more! |                               |
      | Sean Price: Accounting for Taste                                                                                                          | Your Stories | Sean Price                                                                   | 1484     | 1126       | May 2014: The Truth (Is Out There), Part 1                                             |                               |
      | Cynthia Bangert: ... But Lies Are Everywhere                                                                                              | Your Stories | Cynthia Bangert                                                              | 1381     | 1007       | May 2014: The Truth (Is Out There), Part 2                                             |                               |
      | Grace Tran: A Comics Fellowship                                                                                                           | Your Stories | Grace Tran                                                                   | 2832     | 2178       | June 2014: Fellowship, Part 1                                                          |                               |
      | Chris Geiger & Kevin Reader: Goodbye, Steve / Dodo Dumdum                                                                                 | Your Stories | Kevin Reader, Chris Geiger                                                   | 2802     | 2337       | June 2014: Fellowship, Part 2                                                          |                               |
      | Cover Stories: Firework                                                                                                                   | Your Stories | Claire Friedman, Dwight Haesler, Eric Garneau                                | 473      | 151        | August 2014: Fingers Crossed, Part 2                                                   |                               |
      | Cover Stories: 99 Red Balloons (Take 2)                                                                                                   | Your Stories | Claire Friedman, Dwight Haesler, Eric Garneau                                | 371      | 139        | July 2014: Circus, Part 2                                                              |                               |
      | Cover Stories: Poker Face                                                                                                                 | Your Stories | Claire Friedman, Dwight Haesler, Eric Garneau                                | 683      | 420        | August 2014: Fingers Crossed, Part 1                                                   |                               |
      | Cover Stories: Fat Bottomed Girls                                                                                                         | Your Stories | Dwight Haesler, Eric Garneau                                                 | 337      | 124        | September 2014: Bottoms Up, Part 1                                                     |                               |
      | Ryan Bond: Grand Theft Model Car                                                                                                          | Your Stories | Ryan Bond                                                                    | 934      | 192        | September 2014: Bottoms Up, Part 2                                                     |                               |
      | Clayton Margeson: Overboard                                                                                                               | Your Stories | Clayton Margeson                                                             | 1151     | 795        | September 2014 Bonus: Under the Sea Live from the Jangleheart Circus                   |                               |
      | Bill Kenkel: Science Propagandist                                                                                                         | Your Stories | Bill Kenkel                                                                  | 972      | 467        | October 2014: Our Lips Are Sealed, Part 1                                              |                               |
      | Aaron Amendola: The Worst Kind of Breakup                                                                                                 | Your Stories | Aaron Amendola                                                               | 1477     | 790        | October 2014: Our Lips Are Sealed, Part 2                                              |                               |
      | Nathan Robert: Heart Geography                                                                                                            | Your Stories | Nathan Robert                                                                | 1398     | 1057       | November 2014: Heartland, Part 1                                                       |                               |
      | Jennifer Baird: Kansas                                                                                                                    | Your Stories | Jennifer Baird                                                               | 1365     | 1015       | November 2014: Heartland, Part 2                                                       |                               |
      | Ryan Bond: Parental Apocalypse                                                                                                            | Your Stories | Ryan Bond                                                                    | 2799     | 2539       | December 2014: Apocalypse, Part 1                                                      |                               |
      | I Fight Dragons, Dwight Haesler, and Jim Snedeker: Enter Sandman                                                                          | Your Stories | Dwight Haesler, Jim Snedeker, Brian Mazzaferri, Hari Rao                     | 2400     | 2146       | December 2014: Apocalypse, Part 2                                                      |                               |
      | Natasha Samreny: Trip                                                                                                                     | Your Stories | Natasha Samreny                                                              | 4533     | 3657       | Best of Your Stories 2014!                                                             |                               |
      | Mary Zee: Menage a Hah                                                                                                                    | Your Stories | Mary Zee                                                                     | 2925     | 2380       | January 2015: Annual 3, Part 1                                                         |                               |
      | Maggie Wagner: When You Are 12 Years Old                                                                                                  | Your Stories | Maggie Wagner                                                                | 2483     | 2227       | January 2015: Annual 3, Part 2                                                         |                               |
      | The House Theatre Ensemble: The Hammer Trinity prologue Part 2                                                                            | Your Stories | The House Theatre Ensemble                                                   | 2210     | 1770       | February 2015: House Rules, Part 2                                                     |                               |
      | Chris Koterba: The Quest for Farscape Season 2                                                                                            | Your Stories | Chris Koterba                                                                | 2723     | 2310       | February 2015 Bonus: Roll Models live from the Midwinter Gaming Convention, Part 1     |                               |
      | Brad Davies: Swordplay                                                                                                                    | Your Stories | Brad Davies                                                                  | 1708     | 1417       | February 2015 Bonus: Roll Models live from the Midwinter Gaming Convention, Part 2     |                               |
      | Cover Stories: David Duchovny                                                                                                             | Your Stories | Claire Friedman, Eric Garneau                                                | 994      | 694        | March 2015: Fanfiction 3, Part 1                                                       |                               |
      | Dwight & Eric: Hey Jealousy                                                                                                               | Your Stories | Dwight Haesler, Eric Garneau                                                 | 333      | 151        | October 2013: 1993, Part 2                                                             |                               |
      | Cover Stories: Dio                                                                                                                        | Your Stories | Dwight Haesler, Eric Garneau                                                 | 364      | 250        | March 2015: Fanfiction 3, Part 2                                                       |                               |
      | Sawyer Heppes: Born in the '80s and Raised in the '90s                                                                                    | Your Stories | Sawyer Heppes                                                                | 1054     | 742        | October 2013: 1993, Part 1                                                             |                               |
      | Steve Persch: Domain Addiction                                                                                                            | Your Stories | Steve Persch                                                                 | 1402     | 727        | February 2015: House Rules, Part 1                                                     |                               |
      | Mark Colomb - The First Time I: Watched The Empire Strikes Back                                                                           | Your Stories | Mark Colomb                                                                  | 1895     | 1636       | September 2013 Bonus: First Times (live from the Jangleheart Circus!)                  |                               |
      | Mary Beth Smith: Not a Story About a Stolen Bike                                                                                          | Your Stories | Mary Beth Smith                                                              | 1300     | 805        | March 2015 Bonus: Grind, Part 1                                                        |                               |
      | Dwight & Eric: Wish You Were Here                                                                                                         | Your Stories | Dwight Haesler, Eric Garneau                                                 | 3780     | 3530       | September 2013: Best-Laid Plans, Part 2                                                |                               |
      | Emma's new movie Bloodsucking Bastards and her band The Mots Nouveaux (whose name I mispronounced on the episode because I am uncultured) | Your Stories |                                                                              | 0        | 0          | March 2015 Bonus: Grind, Part 1                                                        |                               |
      | Andrew Bentley: 60% Likely To Die of Misadventure                                                                                         | Your Stories | Andrew Bentley                                                               | 3610     | 2985       | September 2013: Best-Laid Plans, Part 1                                                |                               |
      | Kristin's website                                                                                                                         | Your Stories |                                                                              | 0        | 0          | March 2015 Bonus: Grind, Part 2                                                        |                               |
      | Marnie Thompson: The Next Level                                                                                                           | Your Stories | Marnie Thompson                                                              | 2237     | 1916       | August 2013: Games, Part 2                                                             |                               |
      | Debbie Banos: Seeing Grandma Naked                                                                                                        | Your Stories | Debbie Banos                                                                 | 1528     | 1188       | April 2015: Pick a Card, Part 1                                                        |                               |
      | Jae Carbary: I Am a Game Designer                                                                                                         | Your Stories | Jae Carbary                                                                  | 2341     | 2075       | August 2013: Games, Part 1                                                             |                               |
      | Ashley Keenan: Genuine Human Connection                                                                                                   | Your Stories | Ashley Keenan                                                                | 1445     | 1013       | April 2015: Pick a Card, Part 2                                                        |                               |
      | Terry Gant: Superman Reminds Me of Me                                                                                                     | Your Stories | Terry Gant                                                                   | 2618     | 1759       | July 2013 Bonus: Superman                                                              |                               |
      | Vanessa Walilko: (Press Start) on 100%ing                                                                                                 | Your Stories | Vanessa Walilko                                                              | 1817     | 1503       | May 2015: Press Start, Part 1                                                          |                               |
      | Andrew Bentley: The Eritrean War                                                                                                          | Your Stories | Andrew Bentley                                                               | 2860     | 2021       | July 2013: Indie, Part 2                                                               |                               |
      | Logan Dean: (Press Start) on Pinball                                                                                                      | Your Stories | Logan Dean                                                                   | 2132     | 1825       | May 2015: Press Start, Part 2                                                          |                               |
      | Charlie Madsen: Watch Movies Like It's 1999                                                                                               | Your Stories | Charlie Madsen                                                               | 2737     | 2242       | July 2013: Indie, Part 1                                                               |                               |
      | Eric Garneau with Alex Cox: Disembodied Voice                                                                                             | Your Stories | Eric Garneau, Alex Cox                                                       | 1297     | 1023       | May 2015 Bonus: Happy Birthday, Dwight!                                                |                               |
      | Dwight & Eric: Come Sail Away                                                                                                             | Your Stories | Dwight Haesler, Eric Garneau                                                 | 2230     | 1977       | June 2013: Journey, Part 3                                                             |                               |
      | Cover Stories: Kiss from a Rose                                                                                                           | Your Stories | Dwight Haesler, Claire Friedman, Eric Garneau                                | 3700     | 3386       | May 2015 Bonus: Happy Birthday, Dwight!                                                |                               |
      | Dwight & Eric: Here I Go Again                                                                                                            | Your Stories | Dwight Haesler, Eric Garneau                                                 | 505      | 180        | June 2013: Journey, Part 1                                                             |                               |
      | Eric Barry: Escort                                                                                                                        | Your Stories | Eric Barry                                                                   | 2965     | 2334       | June 2015: Sound Idea, Part 1                                                          |                               |
      | Chris Geiger: Campus Cops Are Dicks                                                                                                       | Your Stories | Chris Geiger                                                                 | 837      | 299        | May 2013: Crime and Punishment, Part 3                                                 |                               |
      | Elizabeth Cambridge: Late-Night Habit                                                                                                     | Your Stories | Elizabeth Cambridge                                                          | 3590     | 3286       | June 2015: Sound Idea, Part 2                                                          |                               |
      | Julie Pearson: Steal the Sign                                                                                                             | Your Stories | Julie Pearson                                                                | 1329     | 857        | May 2013: Crime and Punishment, Part 2                                                 |                               |
      | Mike Joosse: Mall Dreams                                                                                                                  | Your Stories | Mike Joosse                                                                  | 3484     | 3014       | July 2015: Discovery, Part 1                                                           |                               |
      | Sawyer Heppes: The Adventures of Schmitty                                                                                                 | Your Stories | Sawyer Heppes                                                                | 2433     | 2057       | May 2013: Crime and Punishment, Part 1                                                 |                               |
      | Cover Stories: Bang Bang (My Baby Shot Me Down)                                                                                           | Your Stories | Claire Friedman, Jim Snedeker                                                | 518      | 347        | August 2015: Fans, Part 1                                                              |                               |
      | Dwight & Eric: Basket Case                                                                                                                | Your Stories | Dwight Haesler, Eric Garneau                                                 | 2868     | 2687       | April 2013: Madness, Part 2                                                            |                               |
      | Ben and Eric: Captain Fantastic and the Brown Dirt Cowboy                                                                                 | Your Stories | Eric Garneau, Ben Rathert                                                    | 4374     | 3970       | August 2015: Fans, Part 1                                                              |                               |
      | Dwight & Eric: Over the Hills and Far Away                                                                                                | Your Stories | Dwight Haesler, Eric Garneau                                                 | 375      | 139        | March 2013: Fanfiction, Part 2                                                         |                               |
      | Mark Colomb: The Necessity of Fandom                                                                                                      | Your Stories | Mark Colomb                                                                  | 3509     | 3072       | August 2015: Fans, Part 2                                                              |                               |
      | Dwight & Eric: Battle of Evermore                                                                                                         | Your Stories | Dwight Haesler, Eric Garneau                                                 | 419      | 140        | March 2013: Fanfiction, Part 1                                                         |                               |
      | Katie Johnston-Smith: Equality                                                                                                            | Your Stories | Katie Johnston-Smith                                                         | 2841     | 2596       | Runt of the Litter, Part 1                                                             |                               |
      | Sawyer Heppes: The Next Audition                                                                                                          | Your Stories | Sawyer Heppes                                                                | 864      | 431        | February 2013 Part 2: Reboot                                                           |                               |
      | Bill Kenkel: K-Selected                                                                                                                   | Your Stories | Bill Kenkel                                                                  | 3215     | 2736       | Runt of the Litter, Part 2                                                             |                               |
      | Steve Persch: It's Never Gonna Happen                                                                                                     | Your Stories | Steve Persch                                                                 | 726      | 471        | February 2013 Part 1: A New Hope                                                       |                               |
      | Cover Stories: Billie Jean                                                                                                                | Your Stories | Jim Snedeker, Eric Garneau, Dwight Haesler                                   | 2816     | 2537       | Authentic Part 1                                                                       |                               |
      | Shawn Boyle: An Apology to Anne Hathaway                                                                                                  | Your Stories | Shawn Patrick Boyle                                                          | 802      | 406        | January 2013 Part 2: Rando                                                             |                               |
      | Cover Stories: Summer of '69                                                                                                              | Your Stories | Dwight Haesler, Eric Garneau, Claire Friedman                                | 427      | 216        | Cards on the Table                                                                     |                               |
      | Andrew Bentley: Friend Break-Up (Giving)                                                                                                  | Your Stories | Andrew Bentley                                                               | 1373     | 1028       | January 2013 Part 1: Mixed Bag                                                         |                               |
      | Cover Stories: Wrecking Ball                                                                                                              | Your Stories | Claire Friedman, Jim Snedeker                                                | 433      | 198        | Kids Again Part 1                                                                      |                               |
      | Dwight & Eric: The Pokemon Theme                                                                                                          | Your Stories | Dwight Haesler, Eric Garneau                                                 | 1839     | 1777       | Best of 2012: Audience Picks                                                           |                               |
      | Cover Stories: Hold On                                                                                                                    | Your Stories | Claire Friedman, Eric Garneau, Jim Snedeker, Dwight Haesler                  | 730      | 474        | Kids Again Part 2                                                                      |                               |
      | Charlie Madsen: Fantasy Madden                                                                                                            | Your Stories | Charlie Madsen                                                               | 1182     | 620        | Best of 2012: Producer’s Picks                                                         |                               |
      | Andrew Bentley: Oatmeal                                                                                                                   | Your Stories | Andrew Bentley                                                               | 1085     | 590        | Horror Stories Part 1                                                                  |                               |
      | Dwight & Eric: Draw a Crowd                                                                                                               | Your Stories | Dwight Haesler, Eric Garneau                                                 | 405      | 179        | December 2012 Part 2: It’s the End of the Year as We Know It                           |                               |
      | Bill Nielsen: "Hostel" Minus the "s"                                                                                                      | Your Stories | Bill Nielsen                                                                 | 1010     | 707        | Horror Stories, Part 2                                                                 |                               |
      | Dwight & Eric: We Are Young                                                                                                               | Your Stories | Dwight Haesler, Eric Garneau                                                 | 3058     | 2797       | December 2012 Part 2: It’s the End of the Year as We Know It                           |                               |
      
