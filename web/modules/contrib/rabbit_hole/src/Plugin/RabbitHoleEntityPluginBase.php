<?php

namespace Drupal\rabbit_hole\Plugin;

use Drupal\Component\Plugin\PluginBase;

/**
 * Base class for Rabbit hole entity plugin plugins.
 */
abstract class RabbitHoleEntityPluginBase extends PluginBase implements RabbitHoleEntityPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function getFormSubmitHandlerAttachLocations() {
    return [['actions', 'submit', '#submit']];
  }

  /**
   * {@inheritdoc}
   */
  public function getBundleFormSubmitHandlerAttachLocations() {
    return [['actions', 'submit', '#submit']];
  }

  /**
   * {@inheritdoc}
   */
  public function getGlobalConfigFormId() {
    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function getGlobalFormSubmitHandlerAttachLocations() {
    return [['actions', 'submit', '#submit']];
  }

  /**
   * {@inheritdoc}
   */
  public function getEntityTokenMap() {
    $map = [];
    $map[$this->pluginDefinition['entityType']]
        = $this->pluginDefinition['entityType'];
    $bundle = \Drupal::entityTypeManager()
        ->getDefinition($this->pluginDefinition['entityType'])
        ->getBundleEntityType();
    if (!empty($bundle)) {
      $map[$bundle] = $bundle;
    }
    return $map;
  }

}
