<?php

/**
 * @file
 * Contains \Drupal\views_custom_cache_tag\Plugin\views\cache\CustomTag.
 */

namespace Drupal\views_custom_cache_tag\Plugin\views\cache;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\cache\Tag;

/**
 * Simple caching of query results for Views displays.
 *
 * @ingroup views_cache_plugins
 *
 * @ViewsCache(
 *   id = "custom_tag",
 *   title = @Translation("Custom Tag based"),
 *   help = @Translation("Tag based caching of data. Caches will persist until any related cache tags are invalidated.")
 * )
 */
class CustomTag extends Tag {

  /**
   * Overrides Drupal\views\Plugin\Plugin::$usesOptions.
   */
  protected $usesOptions = TRUE;

  /**
   * {@inheritdoc}
   */
  public function summaryTitle() {
    return $this->t('Custom Tag');
  }

  /**
   * {@inheritdoc}
   */
  public function defineOptions() {
    $options = parent::defineOptions();
    $options['custom_tag'] = array('default' => '');
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    $form['custom_tag'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Custom tag list'),
      '#description' => $this->t('Custom tag list, separated by new lines. Caching based on custom cache tag must be manually cleared using custom code.'),
      '#default_value' => $this->options['custom_tag'],
    );

    // Setup the tokens for fields.
    $optgroup_arguments = (string) t('Arguments');

    foreach ($this->view->display_handler->getHandlers('argument') as $arg => $handler) {
      $options[$optgroup_arguments]["{{ arguments.$arg }}"] = $this->t('@argument title', array('@argument' => $handler->adminLabel()));
      $options[$optgroup_arguments]["{{ raw_arguments.$arg }}"] = $this->t('@argument input', array('@argument' => $handler->adminLabel()));
    }

    // We have some options, so make a list.
    if (!empty($options)) {
      $output['description'] = [
        '#markup' => '<p>' . $this->t("The following replacement tokens are available for this field. Note that due to rendering order, you cannot use fields that come after this field; if you need a field not listed here, rearrange your fields.") . '</p>',
      ];
      foreach (array_keys($options) as $type) {
        if (!empty($options[$type])) {
          $items = array();
          foreach ($options[$type] as $key => $value) {
            $items[] = $key . ' == ' . $value;
          }
          $item_list = array(
            '#theme' => 'item_list',
            '#items' => $items,
          );
          $output['list'] = $item_list;
        }
      }
      $form['tokens'] = $output;
    }


  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    $id = $this->view->storage->getCacheTags();
    $custom_tags = preg_split('/\r\n|[\r\n]/', $this->options['custom_tag']);
    $custom_tags = array_map('trim', $custom_tags);
    $custom_tags =  array_map(function ($tag){ return $this->view->getStyle()->tokenizeValue($tag, 0);}, $custom_tags);
    return Cache::mergeTags($custom_tags, $id);
  }

  /**
   * {@inheritdoc}
   */
  public function cacheExpire($type) {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function cacheGet($type) {
    $result = parent::cacheGet($type);

    // This can be used to debug/test the views cache result.
    if ($type == 'results' && !$result && \Drupal::state()->get('views_custom_cache_tag.execute_debug', FALSE)) {
      drupal_set_message('Executing view ' . $this->view->storage->id() . ':' . $this->view->current_display . ':' . implode(',', $this->view->args) . ' (' . implode(',', $this->view->getCacheTags()) . ')');
    }
    return $result;
  }

}
