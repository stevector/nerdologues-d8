<?php

namespace Drupal\http2_server_push\Asset;

trait AssetHtmlTagRenderElementTrait {

  /**
   * Whether the render element is a <link rel=stylesheet>.
   *
   * @param array $element
   *   A render element.
   *
   * @return bool
   */
  protected static function isLinkRelStylesheet(array $element) {
    return
      (isset($element['#type']) && $element['#type'] === 'html_tag')
      &&
      (isset($element['#tag']) && $element['#tag'] === 'link')
      &&
      (isset($element['#attributes']) && isset($element['#attributes']['rel']) && $element['#attributes']['rel'] === 'stylesheet');
  }

  /**
   * Whether the render element is a <script>.
   *
   * @param array $element
   *   A render element.
   *
   * @return bool
   */
  protected static function isScript(array $element) {
    return
      (isset($element['#type']) && $element['#type'] === 'html_tag')
      &&
      (isset($element['#tag']) && $element['#tag'] === 'script');
  }

  /**
   * Whether the render element is unconditional.
   *
   * An unconditional element is not browser-specific, i.e. is not wrapped in a
   * conditional comment via the '#browsers' property.
   *
   * @see \Drupal\Core\Render\Element\HtmlTag::preRenderConditionalComments
   *
   * @param array $element
   *   A render element.
   *
   * @return bool
   */
  protected static function isUnconditional(array $element) {
    return empty($element['#browsers']) || ($element['#browsers']['!IE'] === TRUE && $element['#browsers']['IE'] === TRUE);
  }

  /**
   * Whether the given attribute on the render element has a root-relative URL.
   *
   * @param array $element
   *   A render element.
   *
   * @return bool
   */
  protected static function hasRootRelativeUrl(array $element, $attribute_name) {
    $attribute_value = $element['#attributes'][$attribute_name];
    return $attribute_value[0] === '/' && $attribute_value[1] !== '/';
  }

}
