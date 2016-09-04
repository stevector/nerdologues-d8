<?php

/**
 * @file
 * Overriding core file migration for remote files.
 */

namespace Drupal\nerdcustom\Plugin\migrate\destination;

use Drupal\file\Plugin\migrate\destination\EntityFile;
use Drupal\migrate\Row;
use Drupal\migrate\MigrateException;
use Drupal\migrate\Plugin\MigrateIdMapInterface;

/**
 * Overriding core file migration for remote files.
 *
 * @MigrateDestination(
 *   id = "fileremote"
 * )
 */
class EntityFileRemote extends EntityFile {

  /**
   * Finds the entity type from configuration or plugin ID.
   *
   * @param string $plugin_id
   *   The plugin ID.
   *
   * @return string
   *   The entity type.
   */
  protected static function getEntityTypeId($plugin_id) {
    return 'file';
  }

  /**
   * {@inheritdoc}
   */
  public function import(Row $row, array $old_destination_id_values = array()) {

    $this->rollbackAction = MigrateIdMapInterface::ROLLBACK_DELETE;
    $entity = $this->getEntity($row, $old_destination_id_values);
    if (!$entity) {
      throw new MigrateException('Unable to get entity');
    }

    $ids = $this->save($entity, $old_destination_id_values);
    if (!empty($this->configuration['translations'])) {
      $ids[] = $entity->language()->getId();
    }
    return $ids;
  }
}
