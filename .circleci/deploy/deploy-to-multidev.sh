#!/bin/bash
#
# Deploy the current Circle CI build to multidev.
#

set -ex

# delete old multidevs before making a new one
# Only run on even numbered builds to reduce the likelihood of this
# script running on two containers at the same time and causing
# errors.
if [ $(($CIRCLE_BUILD_NUM%2)) -eq 0 ];
then
   terminus env:list --field=id $TERMINUS_SITE | grep "^ci-" | cut -c 4-  | grep -Eo '[0-9]{1,9}' | sort --numeric-sort --reverse | sed 1,7d | xargs -n1 -I ENV terminus env:delete --yes $TERMINUS_SITE.ci-ENV
fi



terminus -n build:env:create "$TERMINUS_SITE.dev" "$TERMINUS_ENV" --yes

terminus connection:set $SITE_ENV sftp
# Send to dev null so that the generated admin password does not show.
# Hiding all output might be overkill for accomplishing that goal.
#terminus drush $SITE_ENV -- si -y config_installer > /dev/null 2>&1
terminus --quiet drupal $SITE_ENV -- site:install   --force --no-interaction
terminus --quiet drupal $SITE_ENV -- config:import --no-interaction
terminus drush $SITE_ENV -- cr
