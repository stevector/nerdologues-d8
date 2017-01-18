#!/bin/bash

set -x

composer global require -n "hirak/prestissimo:^0.3"
composer global require -n "consolidation/cgr"
cgr "pantheon-systems/terminus:~1"
terminus --version
mkdir -p ~/.terminus/plugins
# todo, do I really want the dev-reusue-multidev branch?
composer create-project -n -d ~/.terminus/plugins pantheon-systems/terminus-build-tools-plugin:dev-reuse-multidev
composer create-project -n -d ~/.terminus/plugins pantheon-systems/terminus-secrets-plugin:~1

terminus auth:login -n --machine-token="$TERMINUS_TOKEN"

echo "Installing gulp globally"
npm install -g gulp

