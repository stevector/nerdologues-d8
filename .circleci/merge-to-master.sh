#!/bin/bash

set -eo pipefail



#
# This script handles all operations that must be done when a
# pull request is merged back into the master branch.
#
if [[ $CIRCLE_BRANCH != "master" ]] ; then
  exit 0
fi

{
 terminus auth:login -n --machine-token="$TERMINUS_TOKEN"
} &> /dev/null

# Merge the multidev for the PR into the dev environment
terminus -n build:env:merge "$TERMINUS_SITE.$TERMINUS_ENV" --yes

# Run updatedb on the dev environment
terminus -n drush $TERMINUS_SITE.dev -- updatedb --yes

# If there are any exported configuration files, then import them
if [ -f "config/system.site.yml" ] ; then
  terminus -n drush "$TERMINUS_SITE.dev" -- config-import --yes
fi

# Delete old multidev environments associated with a PR that has been
# merged or closed.
terminus -n build:env:delete:pr "$TERMINUS_SITE" --yes
