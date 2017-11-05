#!/bin/bash

set -x

git config user.email "stevepersch+circleci@gmail.com"
git config user.name "Circle CI Automation"

{
  composer config --global github-oauth.github.com $GITHUB_TOKEN
} &> /dev/null



{
 terminus auth:login -n --machine-token="$TERMINUS_TOKEN"
} &> /dev/null

terminus whoami
