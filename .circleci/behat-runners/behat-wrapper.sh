#!/bin/bash
#
# Deploy the current Circle CI build to multidev.
#

set -ex

# Update Behat Params so that migration tests can be run against Pantheon.
export BEHAT_PARAMS='{"extensions" : {"Behat\\MinkExtension" : {"base_url" : "'$MULTIDEV_SITE_URL'"}}}'

./vendor/bin/behat --config=tests/behat/behat-pantheon.yml --strict --log-step-times "$@"
