#!/bin/bash
#
# Deploy the current Circle CI build to multidev.
#

set -ex


# Drush Behat driver fails without this option.
echo "\$options['strict'] = 0;" >> ~/.drush/pantheon.aliases.drushrc.php
# Update Behat Params so that migration tests can be run against Pantheon.
export BEHAT_PARAMS='{"extensions" : {"Behat\\MinkExtension" : {"base_url" : "http://'$TERMINUS_ENV'-'$TERMINUS_SITE'.pantheonsite.io/"}, "Drupal\\DrupalExtension" : {"drush" :   {  "alias":  "@pantheon.'$TERMINUS_SITE'.'$TERMINUS_ENV'" }}}}'


# delete old multidevs before making a new one
terminus -n build:env:delete:ci "$TERMINUS_SITE" --keep=8 --yes
terminus -n build:env:create "$TERMINUS_SITE.dev" "$TERMINUS_ENV" --yes --notify="$NOTIFY"
# Create a drush alias file so that Behat tests can be executed against Pantheon.
terminus aliases


terminus connection:set $SITE_ENV sftp
# Send to dev null so that the generated admin password does not show.
# Hiding all output might be overkill for accomplishing that goal.
terminus drush $SITE_ENV -- si -y config_installer > /dev/null 2>&1


{
  terminus drush $SITE_ENV -- user-create   $BEHAT_USER_ADMIN  --password=$BEHAT_PASS_ADMIN
  terminus drush $SITE_ENV -- user-add-role administrator   $BEHAT_USER_ADMIN
  terminus drush $SITE_ENV -- user-create   $BEHAT_USER_CONTENT_ADMIN  --password=$BEHAT_PASS_CONTENT_ADMIN
  terminus drush $SITE_ENV -- user-add-role content_administrator   $BEHAT_USER_CONTENT_ADMIN

} &> /dev/null


curl http://$TERMINUS_ENV-$TERMINUS_SITE.pantheonsite.io/
./vendor/bin/behat --config=tests/behat/behat-pantheon.yml --suite=clickdriving --strict




