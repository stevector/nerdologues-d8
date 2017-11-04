
'use strict';

const BackstopReferenceBaseUrl = process.env.MIGRATION_SOURCE_URL;
const BackstopTestUrl = process.env.PANTHEON_SITE_URL;


module.exports = {
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
      "hideSelectors": [],
      "selectors": [
        "document"
      ],
      "readyEvent": null,
      "delay": 1500,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Homepage",
      "url": BackstopTestUrl + "/",
      "referenceUrl": BackstopReferenceBaseUrl + "/",
      "hideSelectors": [],
      "selectors": [
        "document"
      ],
      "readyEvent": null,
      "delay": 1500,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Homepage, Next page",
      "url": BackstopTestUrl + "/home?page=1",
      "referenceUrl": BackstopReferenceBaseUrl + "/home?page=1",
      "hideSelectors": [],
      "selectors": [
        "document"
      ],
      "readyEvent": null,
      "delay": 1500,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Events",
      "url": BackstopTestUrl + "/events",
      "referenceUrl": BackstopReferenceBaseUrl + "/events",
      "hideSelectors": [],
      "selectors": [
        "document"
      ],
      "removeSelectors": [
        ".entity-id-3035.node--view-mode-teaser img",
        "node-teaser.node-3035 img"
      ],
      "readyEvent": null,
      "delay": 1500,
      "misMatchThreshold" : 0.404444444444444444444444
    },
    {
      "label": "Nerds",
      "url": BackstopTestUrl + "/nerds",
      "referenceUrl": BackstopReferenceBaseUrl + "/nerds",
      "hideSelectors": [],
      "selectors": [
        "document"
      ],
      "readyEvent": null,
      "delay": 3000,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Nerd bio",
      "url": BackstopTestUrl + "/nerds/eric-garneau",
      "referenceUrl": BackstopReferenceBaseUrl + "/nerds/eric-garneau",
      "hideSelectors": [],
      "removeSelectors": [
        ".field-name-field-file",
        ".field--name-field-youtube"
      ],
      "requireSameDimensions" : false,
      "selectors": [
        "document"
      ],
      "readyEvent": null,
      "delay": 1500,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Nerd bio 2, MBS",
      "url": BackstopTestUrl + "/nerds/mary-beth-smith",
      "referenceUrl": BackstopReferenceBaseUrl + "/nerds/mary-beth-smith",
      "hideSelectors": [],
      "removeSelectors": [
        ".field-name-field-file",
        ".field--name-field-youtube"
      ],
      "selectors": [
        "document"
      ],
      "requireSameDimensions" : false,
      "readyEvent": null,
      "delay": 1500,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Nerd bio, No clips, Jando",
      "url": BackstopTestUrl + "/nerds/michael-jando",
      "referenceUrl": BackstopReferenceBaseUrl + "/nerds/michael-jando",
      "hideSelectors": [],
      "requireSameDimensions" : false,
      "removeSelectors": [
        ".field-name-field-file",
        ".field--name-field-youtube"
      ],
      "selectors": [
        "document"
      ],
      "readyEvent": null,
      "delay": 1500,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Nerd videos",
      "url": BackstopTestUrl + "/node/72/videos",
      "referenceUrl": BackstopReferenceBaseUrl + "/node/72/videos",
      "hideSelectors": [],
      "removeSelectors": [
        ".field-name-field-file",
        ".field--name-field-youtube"
      ],
      "requireSameDimensions" : false,
      "selectors": [
        "document"
      ],
      "readyEvent": null,
      "delay": 1500,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Nerd videos 2",
      "url": BackstopTestUrl + "/node/73/videos",
      "referenceUrl": BackstopReferenceBaseUrl + "/node/73/videos",
      "hideSelectors": [],
      "requireSameDimensions" : false,
      "removeSelectors": [
        ".field-name-field-file",
        ".field--name-field-youtube"
      ],
      "selectors": [
        "document"
      ],
      "readyEvent": null,
      "delay": 1500,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Clips by person",
      "url": BackstopTestUrl + "/node/29/clips",
      "referenceUrl": BackstopReferenceBaseUrl + "/node/29/clips",
      "hideSelectors": [],
      "selectors": [
        "document"
      ],
      "readyEvent": null,
      "delay": 1500,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Clips by person 2",
      "url": BackstopTestUrl + "/node/73/clips",
      "referenceUrl": BackstopReferenceBaseUrl + "/node/73/clips",
      "hideSelectors": [],
      "selectors": [
        "document"
      ],
      "readyEvent": null,
      "delay": 1500,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Blog post",
      "url": BackstopTestUrl + "/blog/2014-12-29/more-best-your-stories-2014-stuff-wouldnt-fit",
      "referenceUrl": BackstopReferenceBaseUrl + "/blog/2014-12-29/more-best-your-stories-2014-stuff-wouldnt-fit",
      "hideSelectors": [],
      "selectors": [
        "document"
      ],
      "removeSelectors": [
        ".center-wrapper"
      ],
      "readyEvent": null,
      "delay": 1500,
      "requireSameDimensions" : false,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Blog post 2",
      "url": BackstopTestUrl + "/blog/2015-09-08/fisticuffs-character-update-4-metal-devil",
      "referenceUrl": BackstopReferenceBaseUrl + "/blog/2015-09-08/fisticuffs-character-update-4-metal-devil",
      "hideSelectors": [],
      "selectors": [
        "document"
      ],
      "removeSelectors": [
        ".center-wrapper"
      ],
      "readyEvent": null,
      "delay": 1500,
      "requireSameDimensions" : false,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "about",
      "url": BackstopTestUrl + "/nerds-are-funny",
      "referenceUrl": BackstopReferenceBaseUrl + "/nerds-are-funny",
      "hideSelectors": [],
      "selectors": [
        "document"
      ],
      "readyEvent": null,
      "delay": 1500,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "podcasts",
      "url": BackstopTestUrl + "/podcasts",
      "referenceUrl": BackstopReferenceBaseUrl + "/podcasts",
      "hideSelectors": [],
      "selectors": [
        "document"
      ],
      "readyEvent": null,
      "delay": 1500,
      "misMatchThreshold" : 0.69999999999999999999
    },
    {
      "label": "Your stories",
      "url": BackstopTestUrl + "/podcasts/your-stories",
      "referenceUrl": BackstopReferenceBaseUrl + "/podcasts/your-stories",
      "hideSelectors": [],
      "selectors": [
        "document"
      ],
      "readyEvent": null,
      "delay": 1500,
      "misMatchThreshold" : 0.22222222222222222222
    },
    {
      "label": "Episode",
      "url": BackstopTestUrl + "/podcasts/your-stories/episodes/may-2015-press-start-part-1",
      "referenceUrl": BackstopReferenceBaseUrl + "/podcasts/your-stories/episodes/may-2015-press-start-part-1",
      "hideSelectors": [],
      "removeSelectors": [
        ".mediaelement-audio",
        ".field--name-field-file",
        ".todo--dont-remove-the-selctor--------pane-node-field-link-paywall-content",
        ".pane-node-field-link-paywall-content",
        ".todo----dont-remove-p-tags",
        ".block-entity-fieldnodefield-body p",
        ".field-name-field-body p",
      ],
      "selectors": [
        "document"
      ],
      "requireSameDimensions" : false,
      "readyEvent": null,
      "delay": 1500,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Episode 2",
      "url": BackstopTestUrl + "/podcasts/mbsing/episodes/episode-101-mbsing-sean-cooley-idiots",
      "referenceUrl": BackstopReferenceBaseUrl + "/podcasts/mbsing/episodes/episode-101-mbsing-sean-cooley-idiots",
      "hideSelectors": [],
      "removeSelectors": [
        ".mediaelement-audio",
        ".field--name-field-file",
        ".todo----dont-remove-p-tags",
        ".block-entity-fieldnodefield-body p",
        ".field-name-field-body p",
      ],
      "selectors": [
        "document"
      ],
      "requireSameDimensions" : false,
      "readyEvent": null,
      "delay": 1500,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "Clip archive",
      "url": BackstopTestUrl + "/podcasts/your-stories/clips",
      "referenceUrl": BackstopReferenceBaseUrl + "/podcasts/your-stories/clips",
      "hideSelectors": [],
      "removeSelectors": [
        "form"
      ],
      "selectors": [
        "document"
      ],
      "requireSameDimensions" : false,
      "readyEvent": null,
      "delay": 1500,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "clip 1",
      "url": BackstopTestUrl + "/podcasts/your-stories/clips/cover-stories-because-night",
      "referenceUrl": BackstopReferenceBaseUrl + "/podcasts/your-stories/clips/cover-stories-because-night",
      "hideSelectors": [],
      "removeSelectors": [
        ".mediaelement-audio",
        ".field--name-field-int-start-time"
      ],
      "selectors": [
        "document"
      ],
      "readyEvent": null,
      "delay": 1500,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "clip 2",
      "url": BackstopTestUrl + "/podcasts/your-stories/clips/mike-chuck-bretzlaff-selfie-closure",
      "referenceUrl": BackstopReferenceBaseUrl + "/podcasts/your-stories/clips/mike-chuck-bretzlaff-selfie-closure",
      "hideSelectors": [],
      "removeSelectors": [
        ".mediaelement-audio",
        ".field--name-field-int-start-time"
      ],
      "selectors": [
        "document"
      ],
      "readyEvent": null,
      "delay": 1500,
      "misMatchThreshold" : 0.1
    },
    {
      "label": "videos",
      "url": BackstopTestUrl + "/videos",
      "referenceUrl": BackstopReferenceBaseUrl + "/videos",
      "hideSelectors": [],
      "removeSelectors": [
        ".field-name-field-file",
        ".field--name-field-youtube"
      ],
      "selectors": [
        "document"
      ],
      "readyEvent": null,
      "delay": 1500,
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
      "selectors": [
        "document"
      ],
      "readyEvent": null,
      "delay": 1500,
      "requireSameDimensions" : false,
      "misMatchThreshold" : 0.1
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
      "selectors": [
        "document"
      ],
      "requireSameDimensions" : false,
      "readyEvent": null,
      "delay": 1500,
      "misMatchThreshold" : 0.1
    }
  ],
  "paths": {
    "bitmaps_reference": "backstop_data/bitmaps_reference",
    "bitmaps_test": "backstop_data/bitmaps_test",
    "compare_data": "backstop_data/bitmaps_test/compare.json",
    "casper_scripts": "backstop_data/casper_scripts"
  },
  "engine": "phantomjs",
  "report": [ "CLI" ],
  "casperFlags": [],
  "debug": false,
  "port": 3001
}
