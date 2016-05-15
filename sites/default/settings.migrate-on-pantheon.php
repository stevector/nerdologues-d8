<?php

$get_secrets = function() {
  $secretsFile = $_SERVER['HOME'] . '/files/private/secrets.json';
  if (!file_exists($secretsFile)) {
    return [];
  }
  $secretsContents = file_get_contents($secretsFile);
  return json_decode($secretsContents, 1);
};

$secrets = $get_secrets($required_keys, $defaults);

if (!empty($secrets['migrate_source_db__password'])) {
  $databases['drupal_7']['default'] = array (
    'database' => $secrets['migrate_source_db__database'],
    'username' => $secrets['migrate_source_db__username'],
    'password' => $secrets['migrate_source_db__password'],
    'host' => $secrets['migrate_source_db__host'],
    'port' => $secrets['migrate_source_db__port'],
    'driver' => 'mysql',
    'prefix' => '',
    'collation' => 'utf8mb4_general_ci',
  );
}
