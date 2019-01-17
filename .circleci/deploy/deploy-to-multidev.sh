#!/bin/bash
#
# Deploy the current Circle CI build to multidev.
#

set -ex

# Only run on even numbered builds to reduce the likelihood of this
# script running on two containers at the same time and causing
# errors.
if [ $(($CIRCLE_BUILD_NUM%2)) -eq 0 ];
then
   terminus env:list --field=id $TERMINUS_SITE | grep "^ci-" | cut -c 4-  | grep -Eo '[0-9]{1,9}' | sort --numeric-sort --reverse | sed 1,7d | xargs -n1 -I ENV terminus env:delete --yes $TERMINUS_SITE.ci-ENV
fi

terminus -n build:env:create "$TERMINUS_SITE.live" "$TERMINUS_ENV" --yes --clone-content
