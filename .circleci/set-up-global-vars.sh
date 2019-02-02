#!/bin/bash

set -ex

mkdir -p $HOME/.ssh && echo "StrictHostKeyChecking no" >> "$HOME/.ssh/config"

# The TERMINUS_ENV might be persisting from job to job.
if [ -f /tmp/globals/TERMINUS_ENV ]
then
  echo 'export TERMINUS_ENV=$(cat /tmp/globals/TERMINUS_ENV)' >> $BASH_ENV
else
  echo 'export TERMINUS_ENV=ci-$CIRCLE_BUILD_NUM' >> $BASH_ENV
fi

# Make artifacts directory
CIRCLE_ARTIFACTS_DIR='/tmp/artifacts'
mkdir -p $CIRCLE_ARTIFACTS_DIR

(
  echo 'export SITE_ENV=${TERMINUS_SITE}.${TERMINUS_ENV}' >> $BASH_ENV
  echo 'export PANTHEON_DEV_SITE_URL=https://dev-${TERMINUS_SITE}.pantheonsite.io'
  echo 'export PANTHEON_SITE_URL=https://${TERMINUS_ENV}-${TERMINUS_SITE}.pantheonsite.io'
  echo 'CIRCLE_ARTIFACTS_DIR="/tmp/artifacts"'
  echo 'export CIRCLE_ARTIFACTS_URL=${CIRCLE_BUILD_URL}/artifacts/$CIRCLE_NODE_INDEX/artifacts'
  echo 'export PR_NUMBER=${CIRCLE_PULL_REQUEST##*/}'
) >> $BASH_ENV
source $BASH_ENV
