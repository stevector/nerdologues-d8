#!/bin/bash

set -x

composer global require -n "consolidation/cgr"
composer global require -n "hirak/prestissimo:^0.3"
cgr "drush/drush:~8"

git clone --branch master https://github.com/pantheon-systems/terminus.git ~/terminus
cd ~/terminus && composer install

terminus --version
mkdir -p ~/.terminus/plugins
# todo, do I really want the dev-reusue-multidev branch?
composer create-project -n -d ~/.terminus/plugins pantheon-systems/terminus-build-tools-plugin:dev-reuse-multidev
composer create-project -n -d ~/.terminus/plugins pantheon-systems/terminus-secrets-plugin:~1


{
 terminus auth:login -n --machine-token="$TERMINUS_TOKEN"
} &> /dev/null

terminus whoami

echo "Installing gulp globally"
npm install -g gulp

