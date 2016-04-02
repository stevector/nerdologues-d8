<?php










// @todo, make an include file for this
$databases['default']['default'] = array(
      'driver' => 'mysql',
       'database' => 'circle_test',
       'username' => 'ubuntu',
       'password' => '',
       'host' => '127.0.0.1',
       'prefix' => '',
       );
$settings['hash_salt'] = 'adsfasdfqwer';







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
$settings['install_profile'] = 'standard';
$config_directories['sync'] = 'sites/default/config';
