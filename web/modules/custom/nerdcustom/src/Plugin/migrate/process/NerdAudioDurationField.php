<?php

/**
 * @file
 * A process plugin to set audio duration
 *
 * Only nerdologues members should have bio pages.
 */

namespace Drupal\nerdcustom\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;
use Drupal\Core\Database\Database;



/**
 * A process plugin to set audio duration.
 *
 * @MigrateProcessPlugin(
 *   id = "nerd_audio_duration_field"
 * )
 */
class NerdAudioDurationField extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {

    $return = 0;
    $results = Database::getConnection('default', 'drupal_7')
      ->select('field_data_field_int_duration')
      ->fields('field_data_field_int_duration', ['field_int_duration_value'])
      ->condition('field_data_field_int_duration.entity_id', $value)->execute();

    
    foreach ($results as $result) {
      $return = $result->field_int_duration_value;
    }
    return $return;
  }
}
