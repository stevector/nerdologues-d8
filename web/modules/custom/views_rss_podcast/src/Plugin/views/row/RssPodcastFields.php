<?php

/**
 * @file
 * Extend the core RssFields plugin to make a podcast feed.
 */

namespace Drupal\views_rss_podcast\Plugin\views\row;


use Drupal\Core\Form\FormStateInterface;

use Drupal\views\Plugin\views\row\RssFields;

/**
 * Renders an RSS item based on fields.
 *
 * @ViewsRow(
 *   id = "rss_podcast_fields",
 *   title = @Translation("Podcast Fields"),
 *   help = @Translation("Display fields as RSS items for podcasting."),
 *   theme = "views_view_row_rss",
 *   display_types = {"feed"}
 * )
 */
class RssPodcastFields extends RssFields {

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    $initial_labels = ['' => $this->t('- None -')];
    $view_fields_labels = $this->displayHandler->getFieldLabels();
    $view_fields_labels = array_merge($initial_labels, $view_fields_labels);

    foreach ($this->extraFields() as $field_def) {

      $form[$field_def["fapi_key"]] = [
        '#type' => 'select',
        '#title' => $this->t($field_def["fapi_title"]),
        '#description' => $this->t($field_def["fapi_description"]),
        '#options' => $view_fields_labels,
        '#default_value' => $this->options[$field_def["fapi_key"]],
        // '#required' => TRUE,
      ];
    }
  }

  /**
   * {@inheritdoc}
   */
  public function render($row) {
    static $row_index;
    if (!isset($row_index)) {
      $row_index = 0;
    }

    $build = parent::render($row);

    foreach ($this->extraFields() as $field_def) {


      dsm($field_def);
      if (in_array($field_def['fapi_key'], ["enclosure_size", "enclosure_type"])) {
        continue;
      }

      $element_definition = [
        'key' => $field_def["feed_key"],
      ];

      if (!in_array($field_def['fapi_key'], ["enclosure_url"])) {
        $element_definition['value'] = $this->getField($row_index, $this->options[$field_def["fapi_key"]]);
      }
      else {
        $element_definition['attributes'] = [
          "url" => $this->getField($row_index, $this->options["enclosure_url"]),
          'length' => $this->getField($row_index, $this->options["enclosure_size"]),
          'type' => $this->getField($row_index, $this->options["enclosure_type"]),
        ];
      }
dsm($element_definition);
      $build['#row']->elements[] = $element_definition;
    }
    // itunes:image
    return $build;
  }

  /**
   * Defines the additional fields needed to make a podcast feed.
   */
  private function extraFields() {
    return [
      [
        "feed_key" => "enclosure",
        "fapi_key" => "enclosure_url",
        "fapi_title" => "mp3 url",
        "fapi_description" => "absolute url to mp3 file"
      ],
      [
        "feed_key" => "enclosure_size",
        "fapi_key" => "enclosure_size",
        "fapi_title" => "mp3 file size",
        "fapi_description" => "An unformatted integer"
      ],
      [
        "feed_key" => "enclosure_type",
        "fapi_key" => "enclosure_type",
        "fapi_title" => "mp3 file type",
        "fapi_description" => "Mime type"
      ],
      [
        "feed_key" => "itunes:author",
        "fapi_key" => "itunes_author",
        "fapi_title" => "Itunes author duration",
        "fapi_description" => "text to appear in itunes:author"
      ],
      [
        "feed_key" => "itunes:image",
        "fapi_key" => "image_field",
        "fapi_title" => "Itunes image",
        "fapi_description" => "Absolute url for image"
      ],
      [
        "feed_key" => "itunes:explicit",
        "fapi_key" => "explicit_field",
        "fapi_title" => "Itunes explicit",
        "fapi_description" => "yes or no"
      ],
      [
        "feed_key" => "itunes:duration",
        "fapi_key" => "duration_field",
        "fapi_title" => "Itunes item duration",
        "fapi_description" => "The number of seconds in the mp3"
      ],
      [
        "feed_key" => "itunes:summary",
        "fapi_key" => "summary_field",
        "fapi_title" => "Itunes item summary",
        "fapi_description" => "The description of the item"
      ]
    ];
  }
}
