<?php

/**
 * Load services definition file.
 */
$settings['container_yamls'][] = __DIR__ . '/services.yml';

/**
 * Include the Pantheon-specific settings file.
 *
 * n.b. The settings.pantheon.php file makes some changes
 *      that affect all envrionments that this site
 *      exists in.  Always include this file, even in
 *      a local development environment, to insure that
 *      the site settings remain consistent.
 */
include __DIR__ . "/settings.pantheon.php";

/**
 * If there is a local settings file, then include it
 */
$local_settings = __DIR__ . "/settings.local.php";
if (file_exists($local_settings)) {
  include $local_settings;
}

# When on Pantheon, connect to a D7 database.
$migrate_settings = __DIR__ . "/settings.migrate-on-pantheon.php";
if (file_exists($migrate_settings) && isset($_ENV['PANTHEON_ENVIRONMENT'])) {
  include $migrate_settings;
}

$config_directories['sync'] = 'sites/default/config';


$local_services_file = __DIR__ . '/services.local.yml';
if (file_exists($local_services_file)) {
  $settings['container_yamls'][] = $local_services_file;
}

$config_directories[CONFIG_SYNC_DIRECTORY] = '../config';


$settings['install_profile'] = 'config_installer';

