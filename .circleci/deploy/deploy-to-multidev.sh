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
