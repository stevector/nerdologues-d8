#!/bin/bash

set -ex

backstop reference --config=backstop-config.js
backstop test --config=backstop-config.js || echo "backstop failed but this message suppresses a failure of the entire script. The reporting script will detect the fail"

mkdir -p $ARTIFACTS_FULL_DIR
mv backstop_data $ARTIFACTS_FULL_DIR/backstop_data
