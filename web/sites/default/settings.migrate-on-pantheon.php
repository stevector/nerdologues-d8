<?php

/**
 * Get secrets from secrets file.
 *
 * @param array $requiredKeys  List of keys in secrets file that must exist.
 */
// These secret keys come from the script deploy-to-multidev. 
$required_keys = [
  'migrate_source_db__database',
  'migrate_source_db__username',
  'migrate_source_db__password',
  'migrate_source_db__host',
  'migrate_source_db__port'
];
$defaults= array();
$get_secrets = function ($required_keys, $defaults)
{
  $secretsFile = $_SERVER['HOME'] . '/files/private/secrets.json';
  if (!file_exists($secretsFile)) {
    die('No secrets file found. Aborting!');
  }
  $secretsContents = file_get_contents($secretsFile);
  $secrets = json_decode($secretsContents, 1);
  if ($secrets == FALSE) {
    die('Could not parse json in secrets file. Aborting!');
  }
  $secrets += $defaults;
  $missing = array_diff($required_keys, array_keys($secrets));
  if (!empty($missing)) {
    die('Missing required keys in json secrets file: ' . implode(',', $missing) . '. Aborting!');
  }
  return $secrets;
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
