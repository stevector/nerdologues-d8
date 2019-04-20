#!/bin/bash

set -ex

backstop reference --config=backstop-config.js
backstop test --config=backstop-config.js

mkdir -p $ARTIFACTS_FULL_DIR
mv backstop_data $ARTIFACTS_FULL_DIR/backstop_data
