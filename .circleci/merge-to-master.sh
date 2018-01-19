#!/bin/bash

set -ex

git remote add pantheon $(terminus connection:info $TERMINUS_SITE.dev --field=git_url)
terminus -n build:env:merge "$TERMINUS_SITE.$TERMINUS_ENV"
terminus env:clone-content "$TERMINUS_SITE.$TERMINUS_ENV" dev --yes
terminus env:clear-cache "$TERMINUS_SITE.$TERMINUS_ENV"
