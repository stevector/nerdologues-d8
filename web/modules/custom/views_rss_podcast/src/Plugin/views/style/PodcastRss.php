<?php

/**
 * @file
 * Extend the core Rss plugin to make a podcast feed.
 */

namespace Drupal\views_rss_podcast\Plugin\views\style;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\style\Rss;
/**
 * Default style plugin to render an RSS feed.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "podcastrss",
 *   title = @Translation("Podcast RSS Feed"),
 *   help = @Translation("Generates an RSS feed from a view."),
 *   theme = "views_view_rss",
 *   display_types = {"feed"}
 * )
 */
class PodcastRss extends Rss {

  /**
   * {@inheritdoc}
   */
  protected $usesRowPlugin = TRUE;

  protected function defineOptions() {
    $options = parent::defineOptions();

    $options['description'] = ['default' => ''];

    return $options;
  }

  protected function getChannelElements() {
    return [
      [
        '#type' => 'html_tag',
        '#tag' => 'itunes:image',
        "#value" => $this->tokenizeValue($this->options['itunesimage'], 0),
      ]
    ];
  }

  public function render() {

    $return = parent::render();
    // Channel elements depend on rows having already been prepared.
    $this->channel_elements = $this->getChannelElements();
    return $return;
  }


  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    $form['description'] = [
      '#type' => 'textfield',
      '#title' => $this->t('RSS description'),
      '#default_value' => $this->options['description'],
      '#description' => $this->t('This will appear in the RSS feed itself!'),
      '#maxlength' => 1024,
    ];

    $form['itunesimage'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Itunes image'),
      '#default_value' => $this->options['itunesimage'],
      '#description' => $this->t('itunes:image. Use token substitution from fields'),
      '#maxlength' => 1024,
    ];

  }

  /**
   * Get RSS feed description.
   *
   * @return string
   *   The string containing the description with the tokens replaced.
   */
  public function getDescription() {
    $description = $this->options['description'];

    // Allow substitutions from the first row.
    $description = $this->tokenizeValue($description, 0);

    return $description;
  }
}
