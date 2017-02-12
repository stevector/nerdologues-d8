<?php
/**
 * @file
 * Definition of Drupal\mymodule\Plugin\views\filter\RelatedContentTitles.
 */
namespace Drupal\nerdcustom\Plugin\views\filter;
use Drupal\views\Plugin\views\display\DisplayPluginBase;
use Drupal\views\Plugin\views\filter\ManyToOne;
use Drupal\views\ViewExecutable;
/**
 * Filters by given list of related content title options.
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("nerdcustom_referenced_storytellers")
 */
class ReferencedStoryTellers extends ManyToOne {
  /**
   * {@inheritdoc}
   */
  public function init(ViewExecutable $view, DisplayPluginBase $display, array &$options = NULL) {
    parent::init($view, $display, $options);
    $this->valueTitle = t('Allowed referenced storytellers');
    $this->definition['options callback'] = array($this, 'generateOptions');
  }

  /**
   * Helper function that generates the options.
   * @return array
   */
  public function generateOptions() {
    $storage = \Drupal::entityManager()->getStorage('node');

    $relatedContentQuery = \Drupal::entityQuery('node')
        ->condition('type', array('person'), 'IN')
        ->condition('status', 1)
        ->sort('title'); //ensuring that the node is published

    $relatedContentIds = $relatedContentQuery->execute(); //returns an array of node ID's

    $res = array();
    foreach($relatedContentIds as $contentId){
        // building an array with nid as key and title as value
        $res[$contentId] = $storage->load($contentId)->getTitle();
    }

    return $res;
  }
}
