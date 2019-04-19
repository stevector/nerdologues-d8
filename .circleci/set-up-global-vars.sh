#!/bin/bash

set -ex

mkdir -p $HOME/.ssh && echo "StrictHostKeyChecking no" >> "$HOME/.ssh/config"
# Make artifacts directory
CIRCLE_ARTIFACTS_DIR='/tmp/artifacts'
mkdir -p $CIRCLE_ARTIFACTS_DIR


PR_NUMBER=${PR_NUMBER:-$CI_PULL_REQUEST}
CI_BUILD_NUMBER=${CI_BUILD_NUMBER:-$CIRCLE_BUILD_NUM}

# By default, we will make the environment name after the circle build number.
DEFAULT_ENV=ci-$CI_BUILD_NUMBER

# If there is a PR number provided, though, then we will use it instead.
if [[ -n ${PR_NUMBER} ]] ; then
  DEFAULT_ENV="pr-${PR_NUMBER}"
fi

TERMINUS_ENV=${TERMINUS_ENV:-$DEFAULT_ENV}

(
  echo 'export SITE_ENV=${TERMINUS_SITE}.${TERMINUS_ENV}'
  echo 'export PANTHEON_DEV_SITE_URL=https://dev-${TERMINUS_SITE}.pantheonsite.io'
  echo 'export PANTHEON_SITE_URL=https://${TERMINUS_ENV}-${TERMINUS_SITE}.pantheonsite.io'
  echo 'export CYPRESS_baseUrl=https://${TERMINUS_ENV}-${TERMINUS_SITE}.pantheonsite.io'
  echo 'CIRCLE_ARTIFACTS_DIR="/tmp/artifacts"'
  echo 'export CIRCLE_ARTIFACTS_URL=${CIRCLE_BUILD_URL}/artifacts/$CIRCLE_NODE_INDEX/artifact'
  echo 'export PR_NUMBER=${CIRCLE_PULL_REQUEST##*/}'
) >> $BASH_ENV

source $BASH_ENV
