#!/bin/bash
#
# Deploy the current Circle CI build to multidev.
#
git remote add pantheon $(terminus site connection-info --field=git_url)
# @todo, Consider naming based on PR number instead of build number.
git checkout -b $TERMINUS_ENV

mkdir -p ~/terminus/plugins
git clone https://github.com/greg-1-anderson/terminus-secrets-plugin  ~/terminus/plugins/terminus-secrets-plugin

terminus site wake --site=nerdologues --env=migr-prep2
export D7_MYSQL_URL=$(terminus site connection-info --site=nerdologues --env=migr-prep2 --field=mysql_url)
terminus secrets set migrate_source_db__url $D7_MYSQL_URL

git push pantheon $TERMINUS_ENV
# @todo Don't switch to sftp after
# https://www.drupal.org/node/2156401 lands
terminus site set-connection-mode --mode=sftp
# Send to dev null so that the generated admin password does not show.
# Hiding all output might be overkill for accomplishing that goal.
terminus drush "si -y config_installer" > /dev/null 2>&1
terminus drush "ms"
terminus drush "mi --all --feedback='50 items'"
terminus drush "ms"

# Create a drush alias file so that Behat tests can be executed against Pantheon.
terminus sites aliases
# Drush Behat driver fails without this option.
echo "\$options['strict'] = 0;" >> ~/.drush/pantheon.aliases.drushrc.php
# Update Behat Params so that migration tests can be run against Pantheon.
export BEHAT_PARAMS='{"extensions" : {"Behat\\MinkExtension" : {"base_url" : "http://'$TERMINUS_ENV'-'$TERMINUS_SITE'.pantheonsite.io/"}, "Drupal\\DrupalExtension" : {"drush" :   {  "alias":  "@pantheon.nerdologues-d8.'$TERMINUS_ENV'" }}}}'
# Make sure the site is accessible over the web before making requests to it with Behat.
curl http://$TERMINUS_ENV-$TERMINUS_SITE.pantheonsite.io/

cd tests  && ./../vendor/bin/behat --config=behat/behat-pantheon.yml behat/features/migration/ --strict
