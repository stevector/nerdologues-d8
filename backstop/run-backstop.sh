#!/bin/bash

set -ex

CIRCLE_ARTIFACTS_DIR="/tmp/artifacts"
mkdir -p $CIRCLE_ARTIFACTS_DIR

backstop reference --config=backstop-config.js
backstop test --config=backstop-config.js

ls -al

mv backstop_data $CIRCLE_ARTIFACTS_DIR/backstop_data
