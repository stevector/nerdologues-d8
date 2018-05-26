#!/bin/bash


 terminus drush --quiet $SITE_ENV -- upwd   $BEHAT_USER_ADMIN  --password=$BEHAT_PASS_ADMIN
 terminus drush --quiet $SITE_ENV -- upwd  $BEHAT_USER_CONTENT_ADMIN  --password=$BEHAT_PASS_CONTENT_ADMIN
