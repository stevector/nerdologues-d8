'use strict';

const BackstopReferenceBaseUrl = process.env.BACKSTOP_REFERENCE_BASE_URL;
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
      "misMatchThreshold" : 0.36999999999999999
    },
    {
      "label": "Homepage",
      "url": BackstopTestUrl + "/",
      "referenceUrl": BackstopReferenceBaseUrl + "/",


      "delay": 9000,
      "misMatchThreshold" : 0.139999999999999
    },
    {
      "label": "Homepage, Next page",
      "url": BackstopTestUrl + "/home?page=1",
      "referenceUrl": BackstopReferenceBaseUrl + "/home?page=1",


      "delay": 9000,
      "misMatchThreshold" : 0.144444444
    },
    {
      "label": "Events",
      "url": BackstopTestUrl + "/events",
      "referenceUrl": BackstopReferenceBaseUrl + "/events",

      "removeSelectors": [
        "todo-dont-use-such-broad-image-suppression",
        ".views-element-container img",
        ".view-content img",
        ".entity-id-3035 img",
        ".node-3035 img"
      ],

      "requireSameDimensions" : false,
      "delay": 9000,
      "misMatchThreshold" : 0.404444444444444444444444
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

      "removeSelectors": [
        ".field-name-field-file",
        ".field--name-field-youtube"
      ],
      "requireSameDimensions" : false,

      "delay": 9000,
      "misMatchThreshold" : 0.24999999999999
    },
    {
      "label": "Nerd bio 2, MBS",
      "url": BackstopTestUrl + "/nerds/mary-beth-smith",
      "referenceUrl": BackstopReferenceBaseUrl + "/nerds/mary-beth-smith",

      "removeSelectors": [
        ".field-name-field-file",
        ".field--name-field-youtube"
      ],
      "requireSameDimensions" : false,

      "delay": 9000,
      "misMatchThreshold" : 0.133333333333333
    },
    {
      "label": "Nerd bio, No clips, Jando",
      "url": BackstopTestUrl + "/nerds/michael-jando",
      "referenceUrl": BackstopReferenceBaseUrl + "/nerds/michael-jando",

      "requireSameDimensions" : false,
      "removeSelectors": [
        ".field-name-field-file",
        ".field--name-field-youtube"
      ],

      "delay": 9000,
      "misMatchThreshold" : 0.3000999999999
    },
    {
      "label": "Nerd videos",
      "url": BackstopTestUrl + "/node/72/videos",
      "referenceUrl": BackstopReferenceBaseUrl + "/node/72/videos",

      "removeSelectors": [
        ".field-name-field-file",
        ".field--name-field-youtube"
      ],
      "requireSameDimensions" : false,

      "delay": 9000,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Nerd videos 2",
      "url": BackstopTestUrl + "/node/73/videos",
      "referenceUrl": BackstopReferenceBaseUrl + "/node/73/videos",

      "requireSameDimensions" : false,
      "removeSelectors": [
        ".field-name-field-file",
        ".field--name-field-youtube"
      ],

      "delay": 9000,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Clips by person",
      "url": BackstopTestUrl + "/node/29/clips",
      "referenceUrl": BackstopReferenceBaseUrl + "/node/29/clips",


      "delay": 9000,
      "misMatchThreshold" : 0.68888888888
    },
    {
      "label": "Clips by person 2",
      "url": BackstopTestUrl + "/node/73/clips",
      "referenceUrl": BackstopReferenceBaseUrl + "/node/73/clips",


      "delay": 9000,
      "misMatchThreshold" : 0.420999999
    },
    {
      "label": "Blog post",
      "url": BackstopTestUrl + "/blog/2014-12-29/more-best-your-stories-2014-stuff-wouldnt-fit",
      "referenceUrl": BackstopReferenceBaseUrl + "/blog/2014-12-29/more-best-your-stories-2014-stuff-wouldnt-fit",

      "removeSelectors": [
        ".center-wrapper"
      ],

      "delay": 9000,
      "requireSameDimensions" : false,
      "misMatchThreshold" : 0.59099999999
    },
    {
      "label": "Blog post 2",
      "url": BackstopTestUrl + "/blog/2015-09-08/fisticuffs-character-update-4-metal-devil",
      "referenceUrl": BackstopReferenceBaseUrl + "/blog/2015-09-08/fisticuffs-character-update-4-metal-devil",

      "removeSelectors": [
        ".center-wrapper",
        "todo-remove-this-img-suppression",
        ".panel-col-top.panel-panel img",
        ".field--name-field-image-header img",
        "img"
      ],

      "delay": 9000,
      "requireSameDimensions" : false,
      "misMatchThreshold" : 0.460099999
    },
    {
      "label": "about",
      "url": BackstopTestUrl + "/nerds-are-funny",
      "referenceUrl": BackstopReferenceBaseUrl + "/nerds-are-funny",


      "delay": 9000,
      "misMatchThreshold" : 0.12099999
    },
    {
      "label": "podcasts",
      "url": BackstopTestUrl + "/podcasts",
      "referenceUrl": BackstopReferenceBaseUrl + "/podcasts",


      "delay": 9000,
      "misMatchThreshold" : 0.69999999999999999999
    },
    {
      "label": "Your stories",
      "url": BackstopTestUrl + "/podcasts/your-stories",
      "referenceUrl": BackstopReferenceBaseUrl + "/podcasts/your-stories",


      "delay": 9000,
      "misMatchThreshold" : 0.3333333333333333
    },
    {
      "label": "Episode",
      "url": BackstopTestUrl + "/podcasts/your-stories/episodes/may-2015-press-start-part-1",
      "referenceUrl": BackstopReferenceBaseUrl + "/podcasts/your-stories/episodes/may-2015-press-start-part-1",

      "removeSelectors": [
        ".mediaelement-audio",
        ".field--name-field-file",
        ".todo--dont-remove-the-selctor--------pane-node-field-link-paywall-content",
        ".pane-node-field-link-paywall-content",
        ".block-entity-fieldnodefield-link-paywall-content",
        ".todo----dont-remove-p-tags",
        ".block-entity-fieldnodefield-body p",
        ".field-name-field-body p",
      ],
      "requireSameDimensions" : false,

      "delay": 9000,
      "misMatchThreshold" : 0.144444
    },
    {
      "label": "Episode 2",
      "url": BackstopTestUrl + "/podcasts/mbsing/episodes/episode-101-mbsing-sean-cooley-idiots",
      "referenceUrl": BackstopReferenceBaseUrl + "/podcasts/mbsing/episodes/episode-101-mbsing-sean-cooley-idiots",

      "removeSelectors": [
        ".mediaelement-audio",
        ".field--name-field-file",
        ".todo----dont-remove-p-tags",
        ".block-entity-fieldnodefield-body p",
        ".field-name-field-body p",
      ],
      "requireSameDimensions" : false,

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
      "requireSameDimensions" : false,

      "delay": 9000,
      "misMatchThreshold" : 0.70999999999
    },
    {
      "label": "clip 1",
      "url": BackstopTestUrl + "/podcasts/your-stories/clips/cover-stories-because-night",
      "referenceUrl": BackstopReferenceBaseUrl + "/podcasts/your-stories/clips/cover-stories-because-night",

      "removeSelectors": [
        ".mediaelement-audio",
        ".field--name-field-int-start-time"
      ],

      "delay": 9000,
      "misMatchThreshold" : 0.277777777777
    },
    {
      "label": "clip 2",
      "url": BackstopTestUrl + "/podcasts/your-stories/clips/mike-chuck-bretzlaff-selfie-closure",
      "referenceUrl": BackstopReferenceBaseUrl + "/podcasts/your-stories/clips/mike-chuck-bretzlaff-selfie-closure",

      "removeSelectors": [
        ".mediaelement-audio",
        ".field--name-field-int-start-time"
      ],

      "delay": 9000,
      "misMatchThreshold" : 0.333333333
    },
    {
      "label": "videos",
      "url": BackstopTestUrl + "/videos",
      "referenceUrl": BackstopReferenceBaseUrl + "/videos",

      "removeSelectors": [
        ".field-name-field-file",
        ".field--name-field-youtube"
      ],

      "delay": 9000,
      "requireSameDimensions" : false,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Video 1",
      "url": BackstopTestUrl + "/videos/twerking-hard-or-hardly-twerking",
      "referenceUrl": BackstopReferenceBaseUrl + "/videos/twerking-hard-or-hardly-twerking",
      "removeSelectors": [
        "iframe",
        ".field-name-field-file",
        ".field--name-field-youtube"
      ],

      "delay": 9000,
      "requireSameDimensions" : false,
      "misMatchThreshold" : 0.2809999
    },
    {
      "label": "Video 2",
      "url": BackstopTestUrl + "/videos/friends-nerdologues-tim-dunn",
      "referenceUrl": BackstopReferenceBaseUrl + "/videos/friends-nerdologues-tim-dunn",
      "removeSelectors": [
        "iframe",
        ".field-name-field-file",
        ".field--name-field-youtube"
      ],
      "requireSameDimensions" : false,

      "delay": 9000,
      "misMatchThreshold" : 0.14099999
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
