<?php

namespace Drupal\nerdcustom\Plugin\Field\FieldFormatter;


use Drupal\link\Plugin\Field\FieldFormatter\LinkFormatter;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Custom Plugin implementation of the 'link' formatter.
 *
 * @FieldFormatter(
 *   id = "link_patreon",
 *   label = @Translation("Link (with Patreon fallback title)"),
 *   field_types = {
 *     "link"
 *   }
 * )
 */
class LinkPatreonFormatter extends LinkFormatter  {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {

    foreach($items as &$item) {
      $value = $item->getValue();
      if (empty($value['title'])) {
        $value['title'] = "Support us on Patreon to get MP3 access";
        $item->setValue($value);
      }

    }
    return parent::viewElements($items, $langcode);
  }

}
