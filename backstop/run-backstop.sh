#!/bin/bash

set -ex

CIRCLE_ARTIFACTS_DIR="/tmp/artifacts"

backstop reference --config=backstop-config.js
backstop test --config=backstop-config.js

mv backstop_data $CIRCLE_ARTIFACTS_DIR/backstop_data
