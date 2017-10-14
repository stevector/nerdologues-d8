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
    return array(array('actions', 'submit', '#submit'));
  }

  /**
   * {@inheritdoc}
   */
  public function getBundleFormSubmitHandlerAttachLocations() {
    return array(array('actions', 'submit', '#submit'));
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
    return array(array('actions', 'submit', '#submit'));
  }

}
