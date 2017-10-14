<?php

/**
 * @file
 * Contains \Drupal\timeperiod\Plugin\Field\FieldFormatter\Timeperiod.
 */

namespace Drupal\timeperiod\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;


/**
 * @FieldFormatter(
 *  id = "timeperiod",
 *  label = @Translation("Time period"),
 *  field_types = {"integer"}
 * )
 */
class Timeperiod extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return ['granularity' => 4] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {

    $element['granularity'] = [
      '#type' => 'number',
      '#title' => t('Granularity'),
      '#min' => 1,
      '#max' => 4,
      '#default_value' => $this->getSetting('granularity'),
      '#description' => t('The number of different units to display.'),
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary[] = t('Granularity: %granularity', ['%granularity' => $this->getSetting('granularity')]);
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];
    $date_formatter = \Drupal::service("date.formatter");
    foreach ($items as $delta => $item) {
      $element[$delta]['#markup'] = $date_formatter->formatInterval($item->value, $this->getSetting('granularity'));
    }
    return $element;

  }

}
