<?php

  // This file is copied to settings.local.php by circle.yml
  $databases['default']['default'] = array(
    'driver' => 'mysql',
    'database' => getenv('DB_NAME'),
    'username' => getenv('DB_USERNAME'),
    'password' => getenv('DB_PASSWORD'),
    'host' => '127.0.0.1',
    'prefix' => '',
  );

  $databases['drupal_7']['default'] = array (
    'driver' => 'mysql',
    'database' => 'migration_source_db',
    'username' => 'ubuntu',
    'password' => '',
    'host' => '127.0.0.1',
    'prefix' => '',
  );

  $settings['hash_salt'] = 'adsfasdfqwer';
