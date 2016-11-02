#!/bin/bash

set -x

    # Update the backstop.json file to use the multidev environment.
    sed -i -e "s/dev-nerdologues-d8/${TERMINUS_ENV}-nerdologues-d8/g" ~/nerdologues-d8/backstop.json


    # install node dependencies
    echo -e "\nRunning npm install..."
    npm install

    # backstop visual regression
    echo -e "\nRunning BackstopJS tests..."

    cd node_modules/backstopjs

    npm run reference
    # npm run test

    VISUAL_REGRESSION_RESULTS=$(npm run test)

    echo "${VISUAL_REGRESSION_RESULTS}"

    rsync  -rlvz   /home/ubuntu/nerdologues-d8/backstop_data $CIRCLE_ARTIFACTS
