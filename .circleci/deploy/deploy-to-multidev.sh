#!/bin/bash
#
# Deploy the current Circle CI build to multidev.
#

set -ex

# delete old multidevs before making a new one
# @todo This command is not deleting multidevs in the right order,
# nor retain the correct number.
#terminus -n build:env:delete:ci "$TERMINUS_SITE" --keep=8 --yes


terminus -n build:env:create "$TERMINUS_SITE.dev" "$TERMINUS_ENV" --yes  --clone-content

##### terminus connection:set $SITE_ENV sftp
# Send to dev null so that the generated admin password does not show.
# Hiding all output might be overkill for accomplishing that goal.
##### terminus drush $SITE_ENV -- si -y config_installer > /dev/null 2>&1
