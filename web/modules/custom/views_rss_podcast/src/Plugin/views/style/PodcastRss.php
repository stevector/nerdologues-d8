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

  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    $form['description'] = [
      '#type' => 'textfield',
      '#title' => $this->t('RSS description'),
      '#default_value' => $this->options['description'],
      '#description' => $this->t('This will appear in the RSS feed itself!'),
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
