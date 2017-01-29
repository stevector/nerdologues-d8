<?php

/**
 * @file
 * A process plugin to map old roles to new.
 *
 * Only nerdologues members should have bio pages.
 */

namespace Drupal\nerdcustom\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;


/**
 * This plugin maps old roles to new roles.
 *
 * @MigrateProcessPlugin(
 *   id = "nerd_input_format_map"
 * )
 */
class NerdInputFormatMap extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {


    print_r(($value));

    if ('filtered_html' === $value) {

      return 'basic_html';
    }
    return $value;

  }
}
