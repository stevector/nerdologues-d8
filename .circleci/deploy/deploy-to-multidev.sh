#!/bin/bash
#
# Deploy the current Circle CI build to multidev.
#

set -ex

# delete old multidevs before making a new one

terminus env:list --field=id $TERMINUS_SITE | grep "^ci-" | cut -c 4-  | grep -Eo '[0-9]{1,9}' | sort --numeric-sort --reverse | sed 1,7d | xargs -n1 -I ENV terminus env:delete --yes $TERMINUS_SITE.ci-ENV
terminus -n build:env:create "$TERMINUS_SITE.dev" "$TERMINUS_ENV" --yes  --clone-content
