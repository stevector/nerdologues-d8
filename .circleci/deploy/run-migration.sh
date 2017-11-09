#!/bin/bash
#
# Deploy the current Circle CI build to multidev.
#

set -ex

terminus env:wake nerdologues.$D7_ENV
export D7_MYSQL_URL=$(terminus connection:info nerdologues.$D7_ENV --field=mysql_url)
terminus secrets:set $SITE_ENV migrate_source_db__url $D7_MYSQL_URL

terminus drush $SITE_ENV -- ms
terminus drush $SITE_ENV -- mi --all --feedback='50 items'
terminus drush $SITE_ENV -- ms

