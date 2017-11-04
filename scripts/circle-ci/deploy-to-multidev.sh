#!/bin/bash
#
# Deploy the current Circle CI build to multidev.
#

set -ex

terminus env:create $TERMINUS_SITE.dev $TERMINUS_ENV || echo "The multidev may have been made in advance. Return TRUE anyway"

# Create a drush alias file so that Behat tests can be executed against Pantheon.
terminus aliases
# Drush Behat driver fails without this option.
echo "\$options['strict'] = 0;" >> ~/.drush/pantheon.aliases.drushrc.php
# Update Behat Params so that migration tests can be run against Pantheon.
export BEHAT_PARAMS='{"extensions" : {"Behat\\MinkExtension" : {"base_url" : "http://'$TERMINUS_ENV'-'$TERMINUS_SITE'.pantheonsite.io/"}, "Drupal\\DrupalExtension" : {"drush" :   {  "alias":  "@pantheon.'$TERMINUS_SITE'.'$TERMINUS_ENV'" }}}}'
# Make sure the site is accessible over the web before making requests to it with Behat.


# removing settings.local.php is necessary because build tools will force commit everything.
##################################### sudo rm web/sites/default/settings.local.php
##################################### sudo rm -r web/sites/default/files



# delete old multidevs before making a new one
terminus -n build:env:delete:ci "$TERMINUS_SITE" --keep=8 --yes
terminus -n build:env:create "$TERMINUS_SITE.dev" "$TERMINUS_ENV" --yes --notify="$NOTIFY"


# Copy the settings.local back into place (after deleting it above)
# because somehow autoloading with in Behat fails
# if the local Drupal install is broken.
sudo cp scripts/circle-ci/settings.cirlceci.php web/sites/default/settings.local.php

# @todo Don't switch to sftp after
# https://www.drupal.org/node/2156401 lands
terminus connection:set $SITE_ENV sftp
# Send to dev null so that the generated admin password does not show.
# Hiding all output might be overkill for accomplishing that goal.
terminus drush $SITE_ENV -- si -y config_installer > /dev/null 2>&1
curl http://$TERMINUS_ENV-$TERMINUS_SITE.pantheonsite.io/
./vendor/bin/behat --config=tests/behat/behat-pantheon.yml --suite=clickdriving --strict --stop-on-failure




terminus -n build:env:create "$TERMINUS_SITE.dev" "$TERMINUS_ENV" --yes --notify="$NOTIFY"

terminus env:wake nerdologues.$D7_ENV
export D7_MYSQL_URL=$(terminus connection:info nerdologues.$D7_ENV --field=mysql_url)
terminus secrets:set $SITE_ENV migrate_source_db__url $D7_MYSQL_URL

terminus drush $SITE_ENV -- si -y config_installer > /dev/null 2>&1

terminus drush $SITE_ENV -- ms
terminus drush $SITE_ENV -- mi --all --feedback='50 items'
terminus drush $SITE_ENV -- ms
curl http://$TERMINUS_ENV-$TERMINUS_SITE.pantheonsite.io/





curl http://$TERMINUS_ENV-$TERMINUS_SITE.pantheonsite.io/

./vendor/bin/behat --config=tests/behat/behat-pantheon.yml --suite=migration --strict --stop-on-failure
./vendor/bin/behat --config=tests/behat/behat-pantheon.yml --suite=dataentry --strict --stop-on-failure
