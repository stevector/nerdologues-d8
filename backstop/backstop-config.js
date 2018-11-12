'use strict';
// const BackstopReferenceBaseUrl = process.env.BACKSTOP_REFERENCE_BASE_URL;
  const BackstopReferenceBaseUrl = "https://live-nerdologues-composer.pantheonsite.io";
const BackstopTestUrl = process.env.PANTHEON_SITE_URL;
const config = {
  "viewports": [
    {
      "name": "desktop",
      "width": 1280,
      "height": 1080
    }
  ],
  "scenarios": [
    {
      "label": "Clips by person, with quotes",
      "url": BackstopTestUrl + "/node/27/clips",
      "referenceUrl": BackstopReferenceBaseUrl + "/node/27/clips",
      "delay": 9000,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Homepage",
      "url": BackstopTestUrl + "/",
      "referenceUrl": BackstopReferenceBaseUrl + "/",
      "delay": 9000,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Homepage, Next page",
      "url": BackstopTestUrl + "/home?page=1",
      "referenceUrl": BackstopReferenceBaseUrl + "/home?page=1",
      "selectors": [
        "document"
      ],
      "readyEvent": null,

      "delay": 9000,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Events",
      "url": BackstopTestUrl + "/events",
      "referenceUrl": BackstopReferenceBaseUrl + "/events",
      "delay": 9000,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Nerds",
      "url": BackstopTestUrl + "/nerds",
      "referenceUrl": BackstopReferenceBaseUrl + "/nerds",
      "delay": 9000,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Nerd bio",
      "url": BackstopTestUrl + "/nerds/eric-garneau",
      "referenceUrl": BackstopReferenceBaseUrl + "/nerds/eric-garneau",

      "delay": 9000,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Nerd bio 2, MBS",
      "url": BackstopTestUrl + "/nerds/mary-beth-smith",
      "referenceUrl": BackstopReferenceBaseUrl + "/nerds/mary-beth-smith",

      "delay": 9000,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Nerd bio, No clips, Jando",
      "url": BackstopTestUrl + "/nerds/michael-jando",
      "referenceUrl": BackstopReferenceBaseUrl + "/nerds/michael-jando",

      "delay": 9000,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Nerd videos",
      "url": BackstopTestUrl + "/node/72/videos",
      "referenceUrl": BackstopReferenceBaseUrl + "/node/72/videos",

      "delay": 9000,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Nerd videos 2",
      "url": BackstopTestUrl + "/node/73/videos",
      "referenceUrl": BackstopReferenceBaseUrl + "/node/73/videos",

      "delay": 9000,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Clips by person",
      "url": BackstopTestUrl + "/node/29/clips",
      "referenceUrl": BackstopReferenceBaseUrl + "/node/29/clips",
      "delay": 9000,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Clips by person 2",
      "url": BackstopTestUrl + "/node/73/clips",
      "referenceUrl": BackstopReferenceBaseUrl + "/node/73/clips",
      "delay": 9000,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Blog post",
      "url": BackstopTestUrl + "/blog/2014-12-29/more-best-your-stories-2014-stuff-wouldnt-fit",
      "referenceUrl": BackstopReferenceBaseUrl + "/blog/2014-12-29/more-best-your-stories-2014-stuff-wouldnt-fit",

      "delay": 9000,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Blog post 2",
      "url": BackstopTestUrl + "/blog/2015-09-08/fisticuffs-character-update-4-metal-devil",
      "referenceUrl": BackstopReferenceBaseUrl + "/blog/2015-09-08/fisticuffs-character-update-4-metal-devil",

      "delay": 9000,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "about",
      "url": BackstopTestUrl + "/nerds-are-funny",
      "referenceUrl": BackstopReferenceBaseUrl + "/nerds-are-funny",
      "delay": 9000,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Your stories",
      "url": BackstopTestUrl + "/podcasts/your-stories",
      "referenceUrl": BackstopReferenceBaseUrl + "/podcasts/your-stories",
      "selectors": [
        "document"
      ],
      "readyEvent": null,
      "delay": 9000,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Episode",
      "url": BackstopTestUrl + "/podcasts/your-stories/episodes/may-2015-press-start-part-1",
      "referenceUrl": BackstopReferenceBaseUrl + "/podcasts/your-stories/episodes/may-2015-press-start-part-1",

      "delay": 9000,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Episode 2",
      "url": BackstopTestUrl + "/podcasts/mbsing/episodes/episode-101-mbsing-sean-cooley-idiots",
      "referenceUrl": BackstopReferenceBaseUrl + "/podcasts/mbsing/episodes/episode-101-mbsing-sean-cooley-idiots",

      "delay": 9000,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Clip archive",
      "url": BackstopTestUrl + "/podcasts/your-stories/clips",
      "referenceUrl": BackstopReferenceBaseUrl + "/podcasts/your-stories/clips",
      "removeSelectors": [
        "form"
      ],
      "delay": 9000,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "clip 1",
      "url": BackstopTestUrl + "/podcasts/your-stories/clips/cover-stories-because-night",
      "referenceUrl": BackstopReferenceBaseUrl + "/podcasts/your-stories/clips/cover-stories-because-night",
      "delay": 9000,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "clip 2",
      "url": BackstopTestUrl + "/podcasts/your-stories/clips/mike-chuck-bretzlaff-selfie-closure",
      "referenceUrl": BackstopReferenceBaseUrl + "/podcasts/your-stories/clips/mike-chuck-bretzlaff-selfie-closure",
      "delay": 9000,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "videos",
      "url": BackstopTestUrl + "/videos",
      "referenceUrl": BackstopReferenceBaseUrl + "/videos",

      "delay": 9000,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Video 1",
      "url": BackstopTestUrl + "/videos/twerking-hard-or-hardly-twerking",
      "referenceUrl": BackstopReferenceBaseUrl + "/videos/twerking-hard-or-hardly-twerking",
      "delay": 9000,
      "misMatchThreshold" : 0.9
    },
    {
      "label": "Video 2",
      "url": BackstopTestUrl + "/videos/friends-nerdologues-tim-dunn",
      "referenceUrl": BackstopReferenceBaseUrl + "/videos/friends-nerdologues-tim-dunn",
      "delay": 9000,
      "misMatchThreshold" : 1.6
    }
  ],
  "paths": {
    "bitmaps_reference": "backstop_data/bitmaps_reference",
    "bitmaps_test": "backstop_data/bitmaps_test",
    "engine_scripts": "backstop_data/engine_scripts",
    "html_report": "backstop_data/html_report",
    "ci_report": "backstop_data/ci_report"
  },
  "report": ["browser"],
  "engine": "chrome",
  "engineFlags": [],
  "debug": false,
  "debugWindow": false
}
module.exports = config;
