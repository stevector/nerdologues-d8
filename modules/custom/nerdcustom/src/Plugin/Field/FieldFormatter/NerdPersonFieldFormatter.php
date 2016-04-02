<?php

/**
 * @file
 * Contains \Drupal\nerdcustom\Plugin\Field\FieldFormatter\NerdPersonFieldFormatter.
 */

namespace Drupal\nerdcustom\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;


use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceEntityFormatter ;

/**
 * Plugin implementation of the 'nerd_person_field_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "nerd_person_field_formatter",
 *   label = @Translation("Nerd person field formatter"),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class NerdPersonFieldFormatter extends EntityReferenceEntityFormatter  {
  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $view_mode = $this->getSetting('view_mode');
    $elements = array();

    foreach ($this->getEntitiesToView($items, $langcode) as $delta => $entity) {
      if ($this->showEntityLink($entity)) {
        $elements[$delta] = array('#markup' => $entity->link());
      }
      else {
        $elements[$delta] = array('#markup' => $entity->label());
      }
      $elements[$delta]['#cache']['tags'] = $entity->getCacheTags();
    }

    return $elements;
  }

  // @todo, type hinting.
  protected function getReferencedEntityLabels($entity, $field_name = '') {
    $labels = [];
    // To make this code more contrib-able, make the field name a variable.
    foreach ($entity->{$field_name}->referencedEntities() as $term) {
      $labels[] = $term->label();
    }
    return $labels;
  }

  // @todo, type hinting.
  protected function showEntityLink($entity) {
    $labels =  $this->getReferencedEntityLabels($entity, 'field_ref_term_designation');
    return in_array('Viewable bio page', $labels);
  }
}
