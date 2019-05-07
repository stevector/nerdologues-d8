<?php

namespace Drupal\http2_server_push\Render;

use Drupal\Core\Render\AttachmentsInterface;
use Drupal\Core\Render\AttachmentsResponseProcessorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Decorates the HTML response attachments processor service, adds Server Push.
 *
 * @see \Drupal\http2_server_push\Asset\CssCollectionRenderer
 * @see \Drupal\http2_server_push\Asset\JsCollectionRenderer
 */
class HtmlResponseAttachmentsProcessor implements AttachmentsResponseProcessorInterface {

  /**
   * The decorated HTML response attachments processor service.
   *
   * @var \Drupal\Core\Render\AttachmentsResponseProcessorInterface
   */
  protected $htmlResponseAttachmentsProcessor;

  /**
   * The request stack.
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * Constructs a HtmlResponseAttachmentsProcessor object.
   *
   * @param \Drupal\Core\Render\AttachmentsResponseProcessorInterface $html_response_attachments_processor
   *   The decorated HTML response attachments processor service.
   * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
   *   The request stack.
   */
  public function __construct(AttachmentsResponseProcessorInterface $html_response_attachments_processor, RequestStack $request_stack) {
    $this->htmlResponseAttachmentsProcessor = $html_response_attachments_processor;
    $this->requestStack = $request_stack;
  }

  /**
   * {@inheritdoc}
   */
  public function processAttachments(AttachmentsInterface $response) {
    $response = $this->htmlResponseAttachmentsProcessor->processAttachments($response);

    $request = $this->requestStack->getCurrentRequest();
    if ($request->attributes->has('http2_server_push_link_headers')) {
      $link_headers = $request->attributes->get('http2_server_push_link_headers');
      $response->headers->set('Link', $link_headers, FALSE);
    }

    return $response;
  }

}
