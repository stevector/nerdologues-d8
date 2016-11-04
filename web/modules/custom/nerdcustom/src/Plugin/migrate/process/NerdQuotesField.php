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
use Drupal\paragraphs\Entity\Paragraph;
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

    $query = Database::getConnection('default', 'drupal_7')
      ->select('field_data_field_body', 'fdfb');
    $query->join('field_data_field_int_start_time', 'fdfi', 'fdfi.entity_id=fdfb.entity_id');

      $results = $query->fields('fdfb', ['field_body_value'])
          ->fields('fdfi', ['field_int_start_time_value'])
      ->condition('fdfb.entity_id', $value['value'])
        ->condition('fdfi.bundle', 'field_fc_quotes ')
        ->condition('fdfb.bundle', 'field_fc_quotes ')->execute();

      // There really should be only one value in this lloo
    foreach ($results as $result) {
        if (!empty($result->field_body_value)) {
            return $this->makeParagraph($result->field_body_value, $result->field_int_start_time_value);
        }
    }

    return NULL;
  }
  protected function makeParagraph($body, $int_start = NULL) {

    $paragraph = Paragraph::create([
        'type' => 'quotes',   // paragraph type machine name
        'field_body_plain' => [   // paragraph's field machine name
            'value' => $body,                  // body field value
        ],
        'field_int_start_time' => [
            'value' => $int_start,
        ],
    ]);

    $paragraph->save();

    return [
      'target_id' => $paragraph->id(),
      'target_revision_id' => $paragraph->getRevisionId(),
    ];
  }
}
