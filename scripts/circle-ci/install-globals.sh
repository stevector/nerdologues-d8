#!/bin/bash

set -x

composer global require "consolidation/cgr"
composer global require "hirak/prestissimo:^0.3"
cgr "drush/drush:~8"
sudo curl https://github.com/pantheon-systems/terminus/releases/download/0.13.6/terminus.phar -L -o /usr/local/bin/terminus && sudo chmod +x /usr/local/bin/terminus
terminus auth login --machine-token=$TerminusToken
echo "Installing gulp globally"
npm install -g gulp
