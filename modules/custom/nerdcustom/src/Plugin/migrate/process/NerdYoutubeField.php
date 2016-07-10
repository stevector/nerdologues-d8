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
use Drupal\Core\Database\Database;


/**
 * This plugin maps old roles to new roles.
 *
 * @MigrateProcessPlugin(
 *   id = "nerd_youtube_field"
 * )
 */
class NerdYoutubeField extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
      
          $results =  Database::getConnection('default', 'drupal_7')->select('file_managed')
      ->fields('file_managed', array(
        'uri',
      )
              )->condition('file_managed.fid', $value['fid'])->execute();
            
            foreach ($results as $result) {
                $return  = str_replace('oembed://', '', urldecode($result->uri));
                $return  = str_replace('&feature=youtu.be', '', $return);
                return $return;
            }
            
  }
}
