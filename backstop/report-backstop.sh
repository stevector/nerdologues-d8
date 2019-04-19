#!/bin/bash

set -ex

CIRCLE_ARTIFACTS_DIR="/tmp/artifacts"
CIRCLE_ARTIFACTS_URL=${CIRCLE_BUILD_URL}/artifacts/$CIRCLE_NODE_INDEX/artifact

cd $CIRCLE_ARTIFACTS_DIR
DIFF_IMAGE=$(find * -type f -name "failed_diff*.png" | head -n 1)

# Use a diff image if there is one. Otherwise just grab the first image.
if [ -z "$DIFF_IMAGE" ]
then
  IMAGE_TO_LINK=$(find * -type f -name "*desktop*.png" | head -n 1)
  EXITCODE=0
else
  IMAGE_TO_LINK=$DIFF_IMAGE
  EXITCODE=1
fi


diff_image_url=${CIRCLE_ARTIFACTS_URL}/${IMAGE_TO_LINK}
report_url=${CIRCLE_ARTIFACTS_URL}/backstop_data/html_report/index.html
report_link="[![Visual report]($diff_image_url)]($report_url)"
comment="### Visual regression report:"


ls -al /tmp/artifacts

{
  curl -d '{ "body": "'"$comment\\n\\n$report_link"'" }' -X POST https://api.github.com/repos/$CIRCLE_PROJECT_USERNAME/$CIRCLE_PROJECT_REPONAME/commits/$CIRCLE_SHA1/comments?access_token=$GITHUB_TOKEN
} &> /dev/null

exit $EXITCODE
