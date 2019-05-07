

This module attempts to block all Drupal configuration changes.

The main use case is to lock configuration on a prodcution site and import
config using drush that has been validated on a testing copy of the site.

To set a site in read-only mode add this to setting.php:

    $settings['config_readonly'] = TRUE;

To provide a whitelist of configuration that can be changed when in read-only
mode add this to settings.php:

    $settings['config_readonly_whitelist_patterns'] = [
      'config_name.to.ignore',
      'wildcards*allowed',
    ];

Or implement the hook:

    hook_config_readonly_whitelist_patterns() {
      return [
        'config_name.to.ignore',
        'wildcards*allowed',
      ];
    }

To lock production and not other environments, your code in settings.php
might be a conditional on an environment variable like:


    if (isset($_ENV['AH_SITE_ENVIRONMENT']) && $_ENV['AH_SITE_ENVIRONMENT'] === 'prod') {
      $settings['config_readonly'] = TRUE;
    }

The following approaches are somewhat discouraged since they may allow anyone
with drush or shell access to bypass or disable the protection and change
configuration in production.

To allow all changes via the command line and enable readonly mode for the UI only:

    if (PHP_SAPI !== 'cli') {
      $settings['config_readonly'] = TRUE;
    }

You could similarly toggle read-only mode based on the presence or absence of
a file on the webserver (e.g. in a location outside the docroot).

    if (!file_exists('/home/myuser/disable-readonly.txt')) {
      $settings['config_readonly'] = TRUE;
    }
