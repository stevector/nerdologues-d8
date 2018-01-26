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
 *   id = "rss_clips_fields",
 *   title = @Translation("Clips Fields"),
 *   help = @Translation("Display fields for recently saved clips."),
 *   theme = "views_view_row_rss",
 *   display_types = {"feed"}
 * )
 */
class RecentClipsFields extends RssFields {

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
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

    unset($form['title_field']);
    unset($form['link_field']);
    unset($form['description_field']);
    unset($form['creator_field']);
    unset($form['date_field']);
    unset($form['guid_field_options']);
  }

  /**
   * {@inheritdoc}
   */
  public function validate() {
    return [];
  }

  /**
   * Defines the additional fields needed to make a podcast feed.
   */
  private function extraFields() {

    $extra_fields = [
      "title",
      "originalmp3",
      "int_end_time",
      "int_start_time",
      "creators",
      "body",
      "episodetitle",
      "podcast",
      "podcastimage"
    ];
    $return = [];
    foreach ($extra_fields as $extra_field) {
      $return[] = [
        "feed_key" => $extra_field,
        "fapi_key" => $extra_field,
        "fapi_title" => $extra_field,
        "fapi_description" => $extra_field,
      ];
    }

    return $return;
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
      $build['#row']->elements[] = [
       'key' => $field_def["feed_key"],
       'value' => $this->getField($row_index, $this->options[$field_def["fapi_key"]]),
      ];
    }
    return $build;
  }
}
