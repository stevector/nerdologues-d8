#!/bin/bash

set -x

#npm install -g slimerjs

#npm install -g backstopjs

# run screenshots only on master branch.
#todo, detect some pattern in branch name or commit message to also trigger run.

if [   "$CIRCLE_BRANCH" != "master"  ]  &&   [[  $CIRCLE_BRANCH != *"screenshot"* ]]; then
    echo -e "Screenshots only run on master branch or branches containing 'screenshot' Quitting script."
    exit 0;
fi

# Update the backstop.json file to use the multidev environment.
sed -i -e "s/dev-nerdologues-d8/${TERMINUS_ENV}-nerdologues-d8/g" ~/nerdologues-d8/backstop/backstop.json

# install node dependencies
echo -e "\nRunning npm install..."
npm install

# backstop visual regression
echo -e "\nRunning BackstopJS tests..."

cd node_modules/backstopjs

#backstop reference
#backstop test
npm run reference
VISUAL_REGRESSION_RESULTS=$(npm run test)

echo "${VISUAL_REGRESSION_RESULTS}"

rsync  -rlvz   /home/ubuntu/nerdologues-d8/backstop/backstop_data $CIRCLE_ARTIFACTS
