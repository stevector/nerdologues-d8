<?php

/**
 * @file
 * Contains \Drupal\pantheon_advanced_page_cache\EventSubscriber\CacheableResponseSubscriber.
 */

namespace Drupal\pantheon_advanced_page_cache\EventSubscriber;

use Drupal\Core\Cache\CacheableResponseInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CacheableResponseSubscriber implements EventSubscriberInterface {

  /**
   * Adds Surrogate-Key header to cacheable master responses.
   *
   * @param \Symfony\Component\HttpKernel\Event\FilterResponseEvent $event
   *   The event to process.
   */
  public function onRespond(FilterResponseEvent $event) {
    if (!$event->isMasterRequest()) {
      return;
    }

    $response = $event->getResponse();

    if ($response instanceof CacheableResponseInterface) {
      $tags = $response->getCacheableMetadata()->getCacheTags();

      // Rename all _list cache tags to _emit_list to avoid clearing list cache
      // tags by default.
      foreach ($tags as $key => $tag) {
        $tags[$key] = str_replace('_list', '_emit_list', $tag);
      }

      $response->headers->set('Surrogate-Key', implode(' ', $tags));
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::RESPONSE][] = ['onRespond'];
    return $events;
  }

}
