#!/bin/bash

export TERMINUS_ENV=$(cat /tmp/globals/TERMINUS_ENV)
echo TERMINUS_ENV

echo 'export TERMINUS_ENV=${TERMINUS_ENV}' >> $BASH_ENV
source $BASH_ENV


