#!/bin/bash



(
  echo 'export D7_ENV=migr-prep3'
  echo 'export TERMINUS_ENV=ci-$CIRCLE_BUILD_NUM'
  echo 'export SITE_ENV=$TERMINUS_SITE.$TERMINUS_ENV'
  echo 'export MIGRATION_SOURCE_URL="http://$D7_ENV-nerdologues.pantheonsite.io"'
  echo 'export PANTHEON_SITE_URL="http://$TERMINUS_ENV-$TERMINUS_SITE.pantheonsite.io"'
) >> $BASH_ENV
source $BASH_ENV



