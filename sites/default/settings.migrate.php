<?php

/**
 * Get secrets from secrets file.
 *
 * @param array $requiredKeys  List of keys in secrets file that must exist.
 */






$required_keys = [
  'migrate_source_db__db_name',
  'migrate_source_db__username',
  'migrate_source_db__password',
  'migrate_source_db__host',
  'migrate_source_db__port'
];

$secrets = _get_secrets($required_keys, array());

if (!empty($secrets['migrate_source_db__password'])) {

  $databases['drupal_7']['default'] = array (
    'database' => $secrets['migrate_source_db__db_name'],
    'username' => $secrets['migrate_source_db__username'],
    'password' => $secrets['migrate_source_db__password'],
    'host' => $secrets['migrate_source_db__host'],
    'port' => $secrets['migrate_source_db__port'],
    'driver' => 'mysql',
    'prefix' => '',
    'collation' => 'utf8mb4_general_ci',
  );



}
