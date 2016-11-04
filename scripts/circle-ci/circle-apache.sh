#!/bin/bash
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
sudo cp apache-vhost.conf /etc/apache2/sites-available
sudo sed -e "s?%DOCROOT%?$DOCROOT?g" --in-place /etc/apache2/sites-available
sudo sed -e "s?%SERVER%?$SERVER?g" --in-place /etc/apache2/sites-available
sudo a2enmod rewrite
sudo service apache2 restart
