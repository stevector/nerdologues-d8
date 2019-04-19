#!/bin/bash

set -ex


backstop reference --config=backstop-config.js
VISUAL_REGRESSION_RESULTS=$(backstop test --config=backstop-config.js || echo 'true')

mv backstop_data $CIRCLE_ARTIFACTS_DIR/backstop_data
