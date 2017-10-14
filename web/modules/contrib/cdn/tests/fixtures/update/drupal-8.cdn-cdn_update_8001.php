<?php

/**
 * @file
 * Contains database additions to drupal-8.bare.standard.php.gz for testing the
 * upgrade path of cdn_update_8001().
 */

use Drupal\Core\Database\Database;

$connection = Database::getConnection();

// Set the schema version.
$connection->insert('key_value')
  ->fields([
    'collection' => 'system.schema',
    'name' => 'cdn',
    'value' => 'i:8000;',
  ])
  ->execute();

// Update core.extension.
$extensions = $connection->select('config')
  ->fields('config', ['data'])
  ->condition('collection', '')
  ->condition('name', 'core.extension')
  ->execute()
  ->fetchField();
$extensions = unserialize($extensions);
$extensions['module']['cdn'] = 8000;
$connection->update('config')
  ->fields([
    'data' => serialize($extensions),
  ])
  ->condition('collection', '')
  ->condition('name', 'core.extension')
  ->execute();

// Install the default CDN settings, where the only change is that the user has
// configured a CDN domain.
$config = [
  'langcode' => 'en',
  'status' => FALSE,
  'mapping' => [
    'type' => 'simple',
    'domain' => 'cdn.example.com',
    'conditions' => [],
  ],
  'farfuture' => [
    'status' => TRUE,
  ],
];
$data = $connection->insert('config')
  ->fields([
    'name' => 'cdn.settings',
    'data' => serialize($config),
    'collection' => ''
  ])
  ->execute();
