<?php

namespace Drupal\nerdcustom\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * This plugin maps old roles to new roles.
 *
 * @MigrateProcessPlugin(
 *   id = "nerd_date_published"
 * )
 */
class NerdDatePublished extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    $return = str_replace(' ', 'T', $value['value']);
    return $return;
  }

}
