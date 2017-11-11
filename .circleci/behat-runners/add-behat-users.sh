#!/bin/bash


echo "TEST"

echo $SITE_ENV

  terminus drush $TERMINUS_SITE.$TERMINNUS_ENV -- user-create   $BEHAT_USER_ADMIN  --password=$BEHAT_PASS_ADMIN
  terminus drush $TERMINUS_SITE.$TERMINNUS_ENV -- user-add-role administrator   $BEHAT_USER_ADMIN
  terminus drush $TERMINUS_SITE.$TERMINNUS_ENV -- user-create   $BEHAT_USER_CONTENT_ADMIN  --password=$BEHAT_PASS_CONTENT_ADMIN
  terminus drush $TERMINUS_SITE.$TERMINNUS_ENV -- user-add-role content_administrator   $BEHAT_USER_CONTENT_ADMIN

