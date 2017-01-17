#!/bin/bash

set -ex

# Copy the settings.local into place
cp scripts/circle-ci/settings.cirlceci.php web/sites/default/settings.local.php

# Disable sendmail binary to suppress any mailouts.
echo 'sendmail_path = /bin/true' >> ~/.phpenv/versions/$(phpenv version-name)/etc/conf.d/circle.ini
# The memory limit of 128M was breached on site install when adding paragraphs module.
echo "memory_limit = 256M" > ~/.phpenv/versions/$(phpenv version-name)/etc/conf.d/memory.ini

#prepare Apache
sudo usermod -a -G $WEB_GROUP $WEB_USER
echo "<VirtualHost *:80>
          UseCanonicalName Off
          DocumentRoot %DOCROOT%
          ServerName %SERVER%
        <Directory %DOCROOT%>
          Options FollowSymLinks
          AllowOverride All
          RewriteEngine On
          RewriteBase /
          RewriteCond %{REQUEST_FILENAME} !-f
          RewriteCond %{REQUEST_FILENAME} !-d
          RewriteRule %DOCROOT%/(.*)$ index.php/?q=$1 [L,QSA]
          Order allow,deny
          Allow from all
        </Directory>
      </VirtualHost>" > apache-vhost.conf
cp apache-vhost.conf /etc/apache2/sites-available/default
sudo sed -e "s?%DOCROOT%?$DOCROOT?g" --in-place /etc/apache2/sites-available/default
sudo sed -e "s?%SERVER%?$SERVER?g" --in-place /etc/apache2/sites-available/default
sudo a2enmod rewrite
sudo service apache2 restart
