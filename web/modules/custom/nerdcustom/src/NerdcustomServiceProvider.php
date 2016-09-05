<?php

/**
 * @file
 * Swaps services.
 */

namespace Drupal\nerdcustom;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderBase;

/**
 * Swaps services.
 */
class NerdCustomServiceProvider extends ServiceProviderBase {

  /**
   * {@inheritdoc}
   */
  public function alter(ContainerBuilder $container) {
    $definition = $container->getDefinition('stream_wrapper.http');
    $definition->setClass('\Drupal\nerdcustom\StreamWrapper\CachedHttpStreamWrapper');
    $definition = $container->getDefinition('stream_wrapper.https');
    $definition->setClass('\Drupal\nerdcustom\StreamWrapper\CachedHttpStreamWrapper');
  }
}
