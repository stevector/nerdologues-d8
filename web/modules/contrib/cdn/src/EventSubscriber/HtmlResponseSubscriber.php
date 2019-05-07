<?php

namespace Drupal\cdn\EventSubscriber;

use Drupal\cdn\CdnSettings;
use Drupal\Core\Render\HtmlResponse;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class HtmlResponseSubscriber implements EventSubscriberInterface {

  /**
   * The CDN settings service.
   *
   * @var \Drupal\cdn\CdnSettings
   */
  protected $settings;

  /**
   * @param \Drupal\cdn\CdnSettings $cdn_settings
   *   The CDN settings service.
   */
  public function __construct(CdnSettings $cdn_settings) {
    $this->settings = $cdn_settings;
  }

  /**
   * @param \Symfony\Component\HttpKernel\Event\FilterResponseEvent $event
   *   The event to process.
   */
  public function onRespond(FilterResponseEvent $event) {
    $response = $event->getResponse();
    if (!$response instanceof HtmlResponse) {
      return;
    }

    if (!$this->settings->isEnabled()) {
      return;
    }

    // Optimal, so first.
    $this->addPreConnectLinkHeaders($response);
    // Fallback, so second.
    $this->addDnsPrefetchLinkHeaders($response);
  }

  /**
   * Adds DNS prefetch link headers to the HTML response.
   *
   * @param \Drupal\Core\Render\HtmlResponse $response
   *   The HTML response to update.
   *
   * @see https://www.w3.org/TR/resource-hints/#dns-prefetch
   * @todo Remove when http://caniuse.com/link-rel-preconnect has support in all browsers or is equivalent with http://caniuse.com/#feat=link-rel-dns-prefetch
   */
  protected function addDnsPrefetchLinkHeaders(HtmlResponse $response) {
    $domains = $this->settings->getDomains();
    if (count($domains)) {
      $response->headers->set('x-dns-prefetch-control', 'on');
      foreach ($domains as $domain) {
        $response->headers->set('Link', '<//' . $domain . '>; rel=dns-prefetch', FALSE);
      }
    }
  }

  /**
   * Adds preconnect link headers to the HTML response.
   *
   * @param \Drupal\Core\Render\HtmlResponse $response
   *   The HTML response to update.
   *
   * @see https://www.w3.org/TR/resource-hints/#preconnect
   */
  protected function addPreconnectLinkHeaders(HtmlResponse $response) {
    foreach ($this->settings->getDomains() as $domain) {
      $response->headers->set('Link', '<//' . $domain . '>; rel=preconnect; crossorigin', FALSE);
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    // This event subscriber wants to directly manipulate the Symfony response
    // object's headers. Therefore we must run after
    // \Drupal\Core\Render\HtmlResponseAttachmentsProcessor::processAttachments,
    // which would otherwise overwrite us. That is called by
    // \Drupal\Core\EventSubscriber\HtmlResponseSubscriber (priority 0), so
    // use a lower priority.
    $events[KernelEvents::RESPONSE][] = ['onRespond', -10];

    return $events;
  }

}
