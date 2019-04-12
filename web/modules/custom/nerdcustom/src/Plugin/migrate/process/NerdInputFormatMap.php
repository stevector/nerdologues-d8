<?php

namespace Drupal\nerdcustom\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * This plugin maps the filtered_html input format to basic_html.
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

    if ('filtered_html' === $value) {
      return 'basic_html';
    }
    if ('Filtered HTML' === $value) {
      return 'Basic HTML';
    }
    return $value;
  }

}
