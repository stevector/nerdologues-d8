#!/bin/bash

set -x

git config user.email "stevepersch+circleci@gmail.com"
git config user.name "Circle CI Automation"

{
  composer config --global github-oauth.github.com $GITHUB_TOKEN
} &> /dev/null


composer global require -n "consolidation/cgr"
composer global require -n "hirak/prestissimo:^0.3"
cgr "drush/drush:~8"

git clone --branch master https://github.com/pantheon-systems/terminus.git ~/terminus
cd ~/terminus && git checkout 1.5.0 && composer install

terminus --version
mkdir -p ~/.terminus/plugins
# todo, do I really want the dev-reusue-multidev branch?
composer -n create-project -d ~/.terminus/plugins pantheon-systems/terminus-build-tools-plugin:$BUILD_TOOLS_VERSION
composer create-project -n -d ~/.terminus/plugins pantheon-systems/terminus-secrets-plugin:~1

{
 terminus auth:login -n --machine-token="$TERMINUS_TOKEN"
} &> /dev/null

terminus whoami
