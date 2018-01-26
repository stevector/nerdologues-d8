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
 *   help = @Translation("Display fields as RSS items for recently saved clips."),
 *   theme = "views_view_row_rss",
 *   display_types = {"feed"}
 * )
 */
class RecentClipsFields extends RssPodcastFields {

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);


    unset($form['title_field']);
    unset($form['link_field'] );
    unset($form['description_field']);
    unset($form['creator_field'] );
    unset($form['date_field'] );

    unset( $form['guid_field_options']);

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

    "float-end-time",

    "float-start-time",

    "body",

    "episodetitle",

    "podcast",

    "podcastimage"
      ];
    $return = [];
    foreach ($extra_fields as $extra_field) {
      $return[] = [

          "feed_key" => $extra_fields,
        "fapi_key" => $extra_fields,
        "fapi_title" => $extra_fields,
        "fapi_description" => $extra_fields,
      
      ];
    }



    return $return;
  }



}
