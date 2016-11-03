<?php

/**
 * @file
 * A process plugin to set audio duration.
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
 *   id = "nerd_quotes_field"
 * )
 */
class NerdQuotesField extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {



    print_r("\n\n");    print_r("\n\n");
    print_r($value['value']);

    print_r("\n\n");
    $return = 0;
    $query = Database::getConnection('default', 'drupal_7')
      ->select('field_data_field_body');
    $query->join('field_data_field_int_start_time', 'field_data_field_int_start_time', 'field_data_field_int_start_time.entity_id=field_data_field_body.entity_id');

      $results = $query->fields('field_data_field_body', ['field_body_value'])
          ->fields('field_data_field_int_start_time', ['field_int_start_time_value'])
      ->condition('field_data_field_body.entity_id', $value['value'])
        ->condition('field_data_field_int_start_time.bundle', 'field_fc_quotes ')
        ->condition('field_data_field_body.bundle', 'field_fc_quotes ')->execute();

    foreach ($results as $result) {

      print_r($result);
    }


    print_r($return);


    //return $return;


    return null;
  }


  
}
