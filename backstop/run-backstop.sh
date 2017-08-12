#!/bin/bash

npm install -g backstopjs

# Update the URLs in the backstop file to use the new multidev
sed -i -e "s/dev-${TERMINUS_SITE}/${TERMINUS_ENV}-${TERMINUS_SITE}/g" ~/$CIRCLE_PROJECT_REPONAME/backstop/backstop.json

backstop reference
VISUAL_REGRESSION_RESULTS=$(backstop test || echo 'true')

rsync -rlvz backstop_data $CIRCLE_ARTIFACTS

artifact_base_url="https://circleci.com/api/v1.1/project/github/$CIRCLE_PROJECT_USERNAME/$CIRCLE_PROJECT_REPONAME/$CIRCLE_BUILD_NUM/artifacts/0$CIRCLE_ARTIFACTS"

diff_image=$(find * | grep png | grep diff | head -n 1)
diff_image_url=$artifact_base_url/$diff_image
report_url=$artifact_base_url/backstop_data/html_report/index.html
report_link="[![Visual report]($diff_image_url)]($report_url)"
comment="### Visual regression report:"

token="$(composer config --global github-oauth.github.com)"
curl -d '{ "body": "'"$comment\\n\\n$report_link"'" }' -X POST https://api.github.com/repos/$CIRCLE_PROJECT_USERNAME/$CIRCLE_PROJECT_REPONAME/commits/$CIRCLE_SHA1/comments?access_token=$token
