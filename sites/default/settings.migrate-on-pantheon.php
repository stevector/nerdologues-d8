<?php

/**
 * Get secrets from secrets file.
 *
 * @param array $requiredKeys  List of keys in secrets file that must exist.
 */
$get_secrets = function ($required_keys)
{
  $secretsFile = $_SERVER['HOME'] . '/files/private/secrets.json';
  if (!file_exists($secretsFile)) {
    die('No secrets file found.');
  }
  $secretsContents = file_get_contents($secretsFile);
  $secrets = json_decode($secretsContents, 1);
  if ($secrets == FALSE) {
    die('Could not parse json in secrets file.');
  }

  return $secrets;
};
$secrets = $get_secrets();
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
