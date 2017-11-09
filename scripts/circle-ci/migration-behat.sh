#!/bin/bash
#
# Deploy the current Circle CI build to multidev.
#

set -ex




# Update Behat Params so that migration tests can be run against Pantheon.
export BEHAT_PARAMS='{"extensions" : {"Behat\\MinkExtension" : {"base_url" : "http://'$TERMINUS_ENV'-'$TERMINUS_SITE'.pantheonsite.io/"}, "Drupal\\DrupalExtension" : {"drush" :   {  "alias":  "@pantheon.'$TERMINUS_SITE'.'$TERMINUS_ENV'" }}}}'
# Make sure the site is accessible over the web before making requests to it with Behat.


curl http://$TERMINUS_ENV-$TERMINUS_SITE.pantheonsite.io/

./vendor/bin/behat --config=tests/behat/behat-pantheon.yml --suite=migration --strict
./vendor/bin/behat --config=tests/behat/behat-pantheon.yml --suite=dataentry --strict
