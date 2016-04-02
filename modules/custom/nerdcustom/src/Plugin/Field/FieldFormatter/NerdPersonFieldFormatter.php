<?php

/**
 * @file
 * A field formatter to return a person node as a link or plain text.
 *
 * Only nerdologues members should have bio pages.
 */

namespace Drupal\nerdcustom\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceEntityFormatter;

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

  /**
   * Get the referenced entities as an array of labels (strings).
   *
   * @param EntityInterface $entity
   *   The person node to be checked.
   *
   * @return array
   *   An array of strings that are the entity labels.
   */
  protected function getReferencedEntityLabels(EntityInterface $entity, $field_name = '') {
    $labels = [];
    // To make this code more contrib-able, make the field name a variable.
    foreach ($entity->{$field_name}->referencedEntities() as $term) {
      $labels[] = $term->label();
    }
    return $labels;
  }

  /**
   * Determine of the entity should be shown as a link.
   *
   * @param EntityInterface $entity
   *   The person node to be checked.
   *
   * @return bool
   *   True or false for whether the link should be shown.
   */
  protected function showEntityLink(EntityInterface $entity) {
    $labels = $this->getReferencedEntityLabels($entity, 'field_ref_term_designation');
    return in_array('Viewable bio page', $labels);
  }
}
