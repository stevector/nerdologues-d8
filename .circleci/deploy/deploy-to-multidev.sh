#!/bin/bash
#
# Deploy the current Circle CI build to multidev.
#

set -ex

# delete old multidevs before making a new one

terminus -n build:env:create "$TERMINUS_SITE.dev" "$TERMINUS_ENV" --yes  --clone-content
