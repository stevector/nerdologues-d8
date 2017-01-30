<?php

namespace Drupal\nerdcustom\Plugin\Field\Computed;

use Drupal\Core\Field\FieldItemList;
use Drupal\Core\Field\EntityReferenceFieldItemListInterface;

/**
 * A computed property profile's current company.
 */
class ClipMp3 extends FieldItemList implements EntityReferenceFieldItemListInterface {

  /**
   * Implements \Drupal\Core\TypedData\TypedDataInterface::getValue().
   */
  public function getValue($langcode = NULL) {
    // Get professional experience field.
    $profile = $this->getEntity();
    //$position = bix_profile_get_current_position($profile);
    return 'https://podcasts.nerdologues.com/blankcassette/BillsRioDiamond500Mix.mp3';
  }

  public function referencedEntities() {
    return [];
  }

}

