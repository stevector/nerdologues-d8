#!/bin/bash

set -ex

{
 terminus auth:login -n --machine-token="$TERMINUS_TOKEN"
} &> /dev/null
terminus whoami

git remote add pantheon $(terminus connection:info $TERMINUS_SITE.dev --field=git_url)
terminus -n build:env:merge "$TERMINUS_SITE.$TERMINUS_ENV"
terminus env:clear-cache "$TERMINUS_SITE.$TERMINUS_ENV"
