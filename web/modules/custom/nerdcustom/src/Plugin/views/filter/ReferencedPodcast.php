<?php

/**
 * @file
 * Definition of Drupal\mymodule\Plugin\views\filter\ReferencedPodcast.
 */

namespace Drupal\nerdcustom\Plugin\views\filter;
use Drupal\views\Plugin\views\display\DisplayPluginBase;
use Drupal\views\Plugin\views\filter\ManyToOne;
use Drupal\views\ViewExecutable;

/**
 * Filters by given list of storytellers.
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("nerdcustom_referenced_podcast")
 */
class ReferencedPodcast extends ManyToOne {

  /**
   * {@inheritdoc}
   */
  public function init(ViewExecutable $view, DisplayPluginBase $display, array &$options = NULL) {
    parent::init($view, $display, $options);
    $this->valueTitle = t('Allowed referenced podcasts');
    $this->definition['options callback'] = array($this, 'generateOptions');
  }

  /**
   * Helper function that generates the options.
   *
   * @return array
   *   The array of Nids and Titles
   */
  public function generateOptions() {
    $storage = \Drupal::entityManager()->getStorage('node');

    $related_content_query = \Drupal::entityQuery('node')
        ->condition('type', 'podcast')
        ->condition('status', 1)
        ->sort('title');

    $related_content_ids = $related_content_query->execute();

    $res = array();
    foreach ($related_content_ids as $content_id) {
      // Building an array with nid as key and title as value.
      $res[$content_id] = $storage->load($content_id)->getTitle();
    }

    return $res;
  }
}
