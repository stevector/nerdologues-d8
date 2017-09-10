<?php

namespace Drupal\http2_server_push\Asset;

use Drupal\Core\Asset\AssetCollectionRendererInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Decorates the CSS collection renderer service, adds Server Push.
 *
 * @see \Drupal\Core\Asset\CssCollectionRenderer
 * @see \Drupal\http2_server_push\Render\HtmlResponseAttachmentsProcessor
 */
class CssCollectionRenderer implements AssetCollectionRendererInterface {

  use AssetHtmlTagRenderElementTrait;

  /**
   * The decorated CSS collection renderer.
   *
   * @var \Drupal\Core\Asset\AssetCollectionRendererInterface
   */
  protected $cssCollectionRenderer;

  /**
   * The request stack.
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * Constructs a CssCollectionRenderer.
   *
   * @param \Drupal\Core\Asset\AssetCollectionRendererInterface $css_collection_renderer
   *   The decorated CSS collection renderer.
   * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
   *   The request stack.
   */
  public function __construct(AssetCollectionRendererInterface $css_collection_renderer, RequestStack $request_stack) {
    $this->cssCollectionRenderer = $css_collection_renderer;
    $this->requestStack = $request_stack;
  }

  /**
   * {@inheritdoc}
   */
  public function render(array $css_assets) {
    $elements = $this->cssCollectionRenderer->render($css_assets);

    $request = $this->requestStack->getCurrentRequest();
    $link_headers = $request->attributes->get('http2_server_push_link_headers', []);
    foreach ($elements as &$element) {
      if (!static::isLinkRelStylesheet($element)) {
        continue;
      }

      // Locally served CSS files that are sent to all browsers can be pushed.
      if (isset($element['#attributes']['href']) && static::hasRootRelativeUrl($element, 'href') && static::isUnconditional($element)) {
        $link_header_value = '<' . $element['#attributes']['href'] . '>; rel=preload; as=style';
        $link_headers[] = $link_header_value;

        // @todo When this is moved into Drupal core, consider allowing bubbling
        // of bubbleable metadata from the return value of
        // \Drupal\Core\Render\HtmlResponseAttachmentsProcessor::processAssetLibraries
        // so this line of code can work, which would mean we would no longer
        // need to use request attributes. (The problem is that a key assumption
        // is that rendering set of asset libraries to HTML that loads CSS/JS,
        // no further attachment bubbling happens. That's a fine assumption, but
        // this module is the first and sole exception.)
        //$element['#attached']['http_header'][] = ['Link', $link_header_value];
      }
    }
    $request->attributes->set('http2_server_push_link_headers', $link_headers);
    return $elements;
  }

}
