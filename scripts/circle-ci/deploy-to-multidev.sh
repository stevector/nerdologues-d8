#!/bin/bash
#
# Deploy the current Circle CI build to multidev.
#

set -ex




# delete old multidevs before making a new one
#terminus -n build:env:delete:ci "$TERMINUS_SITE" --keep=8 --yes
terminus -n build:env:create "$TERMINUS_SITE.dev" "$TERMINUS_ENV" --yes --notify="$NOTIFY"
# Create a drush alias file so that Behat tests can be executed against Pantheon.
terminus aliases
# Drush Behat driver fails without this option.
echo "\$options['strict'] = 0;" >> ~/.drush/pantheon.aliases.drushrc.php



# @todo Don't switch to sftp after
# https://www.drupal.org/node/2156401 lands
terminus connection:set $SITE_ENV sftp
# Send to dev null so that the generated admin password does not show.
# Hiding all output might be overkill for accomplishing that goal.
terminus drush $SITE_ENV -- si -y config_installer > /dev/null 2>&1


