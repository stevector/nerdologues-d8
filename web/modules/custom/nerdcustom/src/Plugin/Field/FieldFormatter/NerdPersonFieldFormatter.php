<?php

namespace Drupal\nerdcustom\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
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
class NerdPersonFieldFormatter extends EntityReferenceEntityFormatter {

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

    $elements = [];

    foreach ($this->getEntitiesToView($items, $langcode) as $delta => $entity) {
      if ($this->showEntityLink($entity)) {
        $elements[$delta] = ['#markup' => $entity->link()];
      }
      else {
        $elements[$delta] = ['#markup' => $entity->label()];
      }
      $elements[$delta]['#cache']['tags'] = $entity->getCacheTags();
    }

    return $elements;
  }

  /**
   * Get the referenced entities as an array of labels (strings).
   *
   * @param Drupal\Core\Entity\EntityInterface $entity
   *   The person node to be checked.
   * @param string $field_name
   *   The field doing the referencing.
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
   * @param Drupal\Core\Entity\EntityInterface $entity
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
