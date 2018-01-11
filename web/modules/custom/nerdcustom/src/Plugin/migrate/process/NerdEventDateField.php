<?php

/**
 * @file
 * A process plugin to create quote paragraph entities from field collections.
 */

namespace Drupal\nerdcustom\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;
use Drupal\Core\Database\Database;
use Drupal\paragraphs\Entity\Paragraph;

/**
 * A process plugin to create date values from field collections.
 *
 * @MigrateProcessPlugin(
 *   id = "nerd_eventdate_field"
 * )
 */
class NerdEventDateField extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {

    $results = Database::getConnection('default', 'drupal_7')
      ->select('field_data_field_date', 'fdf_date')
      ->fields('fdf_date', ['field_date_value'])
      ->condition('fdf_date.entity_id', $value['value'])
      ->condition('fdf_date.bundle', 'field_fc_dates')->execute();

    // There really should be only one value in this loop.
    foreach ($results as $result) {

      if (!empty($result->field_date_value)) {
        return str_replace(' ', 'T', $result->field_date_value);
      }
    }

    return NULL;
  }

}
