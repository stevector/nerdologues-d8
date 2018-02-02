#!/bin/bash


set -x

git config user.email "stevepersch+circleci@gmail.com"
git config user.name "Circle CI Automation"

mkdir -p $HOME/.ssh && echo "StrictHostKeyChecking no" >> "$HOME/.ssh/config"

{
  composer config --global github-oauth.github.com $GITHUB_TOKEN
} &> /dev/null



{
 terminus auth:login -n --machine-token="$TERMINUS_TOKEN"
} &> /dev/null

terminus whoami


(
  echo 'export D7_ENV=migr-prep5'
  echo 'export TERMINUS_ENV=ci-$CIRCLE_BUILD_NUM'
  echo 'export SITE_ENV=$TERMINUS_SITE.$TERMINUS_ENV'
  echo 'export MIGRATION_SOURCE_URL="http://$D7_ENV-nerdologues.pantheonsite.io"'
  echo 'export PANTHEON_SITE_URL="http://$TERMINUS_ENV-$TERMINUS_SITE.pantheonsite.io"'
) >> $BASH_ENV
source $BASH_ENV



