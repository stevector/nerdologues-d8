<?php

/**
 * @file
 * Contains \Drupal\timeperiod\Plugin\Field\FieldWidget\Timeperiod.
 */

namespace Drupal\timeperiod\Plugin\Field\FieldWidget;

use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;


/**
 * @FieldWidget(
 *  id = "timeperiod",
 *  label = @Translation("Time period"),
 *  field_types = {"integer"}
 * )
 */
class Timeperiod extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'days' => FALSE,
      'days_step' => 1,
      'hours' => TRUE,
      'hours_step' => 1,
      'minutes' => TRUE,
      'minutes_step' => 1,
      'seconds' => TRUE,
      'seconds_step' => 10,
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {

    $settings = $this->getSettings();
    $field_name = $this->fieldDefinition->getName();

    $element['days'] = [
      '#type' => 'checkbox',
      '#title' => t('Days'),
      '#default_value' => $settings['days'],
    ];
    $element['days_step'] = [
      '#type' => 'number',
      '#title' => t('Days step'),
      '#min' => 1,
      '#default_value' => $settings['days_step'],
      '#states' => [
        'visible' => ["input[name='fields[$field_name][settings_edit_form][settings][days]']" => ['checked' => TRUE]],
      ],
    ];

    $element['hours'] = [
      '#type' => 'checkbox',
      '#title' => t('Hours'),
      '#default_value' => $settings['hours'],
    ];
    $element['hours_step'] = [
      '#type' => 'number',
      '#title' => t('Hours step'),
      '#min' => 1,
      '#max' => 12,
      '#default_value' => $settings['hours_step'],
      '#states' => [
        'visible' => ["input[name='fields[$field_name][settings_edit_form][settings][hours]']" => ['checked' => TRUE]],
      ],
    ];

    $element['minutes'] = [
      '#type' => 'checkbox',
      '#title' => t('Minutes'),
      '#default_value' => $settings['minutes'],
    ];
    $element['minutes_step'] = [
      '#type' => 'number',
      '#title' => t('Minutes step'),
      '#min' => 1,
      '#max' => 30,
      '#default_value' => $settings['minutes_step'],
      '#states' => [
        'visible' => ["input[name='fields[$field_name][settings_edit_form][settings][minutes]']" => ['checked' => TRUE]],
      ],
    ];

    $element['seconds'] = [
      '#type' => 'checkbox',
      '#title' => t('Seconds'),
      '#default_value' => $settings['seconds'],
    ];
    $element['seconds_step'] = [
      '#type' => 'number',
      '#title' => t('Seconds step'),
      '#min' => 1,
      '#max' => 30,
      '#default_value' => $settings['seconds_step'],
      '#states' => [
        'visible' => ["input[name='fields[$field_name][settings_edit_form][settings][seconds]']" => ['checked' => TRUE]],
      ],
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    $settings = $this->getSettings();

    if ($settings['days']) {
      $summary[] = t('Days step: %step', ['%step' => $settings['days_step']]);
    }
    if ($settings['hours']) {
      $summary[] = t('Hours step: %step', ['%step' => $settings['hours_step']]);
    }
    if ($settings['minutes']) {
      $summary[] = t('Minutes step: %step', ['%step' => $settings['minutes_step']]);
    }
    if ($settings['seconds']) {
      $summary[] = t('Seconds step: %step', ['%step' => $settings['seconds_step']]);
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {

    $settings = $this->getSettings();

    $value = isset($items[$delta]->value) ? $items[$delta]->value : 0;

    // @TODO: Display it as inline elements.
    $units['days'] = [
      'label' => t('Days'),
      'max' => 365,
      'value' => 86400,
    ];

    $units['hours'] = [
      'label' => t('Hours'),
      'max' => 23,
      'value' => 3600,
    ];

    $units['minutes'] = [
      'label' => t('Minutes'),
      'max' => 59,
      'value' => 60,
    ];

    $units['seconds'] = [
      'label' => t('Seconds'),
      'max' => 59,
      'value' => 1,
    ];

    foreach ($units as $key => $unit) {
      if ($settings[$key]) {
        $widget[$key] = [
          '#title' => $unit['label'],
          '#type' => 'number',
          '#min' => 0,
          '#max' => $unit['max'],
          '#step' => $settings[$key . '_step'],
          '#default_value' => intval($value / $unit['value']),
          '#class' => ['timeperiod-unit', 'timeperiod-unit-' . $key],
        ];
        $value -= $widget[$key]['#default_value'] * $unit['value'];
      }
    }

    $element['#type'] = 'fieldgroup';
    $element['#tree'] = TRUE;
    $element['#collapsible'] = FALSE;
    $element = $element + $widget;
    $element['#attached']['library'][] = 'timeperiod/timeperiod-form';
    //header('content-type:text/plain');
    //var_dump($element);
    //exit;
    return $element;

  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    foreach ($values as $delta => $value) {
      $values[$delta]['value'] = 86400 * $value['days'] + 3600 * $value['hours'] + 60 * $value['minutes'] + $value['seconds'];
    }
    return $values;
  }

}
