#!/bin/bash

set -ex

terminus aliases
export BEHAT_PARAMS='{"extensions" : {"Behat\\MinkExtension" : {"base_url" : "http://'$TERMINUS_ENV'-'$TERMINUS_SITE'.pantheonsite.io/"}, "Drupal\\DrupalExtension" : {"drush" :   {  "alias":  "@pantheon.'$TERMINUS_SITE'.'$TERMINUS_ENV'" }}}}'
curl http://$TERMINUS_ENV-$TERMINUS_SITE.pantheonsite.io/
./vendor/bin/behat --config=tests/behat/behat-pantheon.yml --suite=clickdriving --strict
