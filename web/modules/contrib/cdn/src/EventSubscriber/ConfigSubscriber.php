<?php

namespace Drupal\cdn\EventSubscriber;

use Drupal\Core\Cache\CacheTagsInvalidatorInterface;
use Drupal\Core\Config\ConfigCrudEvent;
use Drupal\Core\Config\ConfigEvents;
use Drupal\Core\DrupalKernelInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Invalidates cache tags & rebuilds container when necessary.
 */
class ConfigSubscriber implements EventSubscriberInterface {

  /**
   * The cache tags invalidator.
   *
   * @var \Drupal\Core\Cache\CacheTagsInvalidatorInterface
   */
  protected $cacheTagsInvalidator;

  /**
   * The Drupal kernel.
   *
   * @var \Drupal\Core\DrupalKernelInterface
   */
  protected $drupalKernel;

  /**
   * Constructs a ConfigSubscriber object.
   *
   * @param \Drupal\Core\Cache\CacheTagsInvalidatorInterface $cache_tags_invalidator
   *   The cache tags invalidator.
   * @param \Drupal\Core\DrupalKernelInterface $drupal_kernel
   *   The Drupal kernel.
   */
  public function __construct(CacheTagsInvalidatorInterface $cache_tags_invalidator, DrupalKernelInterface $drupal_kernel) {
    $this->cacheTagsInvalidator = $cache_tags_invalidator;
    $this->drupalKernel = $drupal_kernel;
  }

  /**
   * Invalidates all render caches when CDN settings are modified.
   *
   * @param \Drupal\Core\Config\ConfigCrudEvent $event
   *   The Event to process.
   */
  public function onSave(ConfigCrudEvent $event) {
    if ($event->getConfig()->getName() === 'cdn.settings') {
      $this->cacheTagsInvalidator->invalidateTags([
        // Rendered output that is cached. (HTML containing URLs.)
        'rendered',
      ]);

      // Rebuild the container whenever the 'status' configuration changes.
      // @see \Drupal\cdn\CdnServiceProvider
      if ($event->isChanged('status')) {
        $this->drupalKernel->invalidateContainer();
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[ConfigEvents::SAVE][] = ['onSave'];
    return $events;
  }

}
