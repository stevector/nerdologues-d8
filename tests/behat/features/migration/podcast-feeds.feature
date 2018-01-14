Feature: Podcast feeds

   @api
   Scenario: Podcast feed
     When I visit "podcasts/your-stories/feed"
     Then the response should contain "<title>The Nerdologues Present: Your Stories</title>"
     When I visit "/podcasts/mbsing/feed"
     Then the response should contain "<title>The Nerdologues Present: MBSing"
     When I visit "/podcasts/nerdologuecast/feed"
     Then the response should contain "<title>The Nerdologues Present: The Nerdologuecast"
     When I visit "/podcasts/talking-games/feed"
     Then the response should contain "<title>The Nerdologues Present: Talking Games"
     When I visit "/podcasts/poor-choices/feed"
     Then the response should contain "<title>The Nerdologues Present: Poor Choices"
     When I visit "/podcasts/ketchup/feed"
     Then the response should contain "<title>The Nerdologues Present: The Ketchup"
     When I visit "/podcasts/sports-retorts-hooli-and-joe/feed"
     Then the response should contain "<title>The Nerdologues Present: Sports Retorts with Hooli and The Joe"
     When I visit "/podcasts/blank-cassette/feed"
     Then the response should contain "<title>The Nerdologues Present: Blank Cassette"

