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


    print_r($value);

    /*
        $query = Database::getConnection('default', 'drupal_7')
          ->select('field_data_field_body', 'fdfb');
        $query->join('field_data_field_int_start_time', 'fdfi', 'fdfi.entity_id=fdfb.entity_id');

        $results = $query->fields('fdfb', ['field_body_value'])
          ->fields('fdfi', ['field_int_start_time_value'])
          ->condition('fdfb.entity_id', $value['value'])
          ->condition('fdfi.bundle', 'field_fc_quotes ')
          ->condition('fdfb.bundle', 'field_fc_quotes ')->execute();

        // There really should be only one value in this loop.
        foreach ($results as $result) {
          if (!empty($result->field_body_value)) {
            return $this->makeParagraph($result->field_body_value, $result->field_int_start_time_value);
          }
        }


    */

    return NULL;
  }



}
