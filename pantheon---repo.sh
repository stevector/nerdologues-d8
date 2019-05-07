
#!/bin/bash

set -ex

export PANTHEON_REPO_DIR="/tmp/pantheon_repo_for_$TERMINUS_SITE_$UNIQUEHASH"

if [ ! -d "$PANTHEON_REPO_DIR" ]; then
  mkdir $PANTHEON_REPO_DIR
  git -C $PANTHEON_REPO_DIR init
  git -C $PANTHEON_REPO_DIR remote add pantheon $(terminus connection:info $TERMINUS_SITE.dev --field=git_url)
  git -C $PANTHEON_REPO_DIR remote -v
fi

git -C $PANTHEON_REPO_DIR fetch pantheon


REMOTE_REF=$(git -C /tmp/pantheon_repo_for_bb ls-remote pantheon | grep "refs/heads/$TERMINUS_ENV$")

if [ -n "$REMOTE_REF" ]; then
  git -C $PANTHEON_REPO_DIR checkout $TERMINUS_ENV
  git -C $PANTHEON_REPO_DIR pull
else
  git -C $PANTHEON_REPO_DIR checkout master
  git -C $PANTHEON_REPO_DIR pull
  git -C $PANTHEON_REPO_DIR checkout -b $TERMINUS_ENV
fi

git -C $PANTHEON_REPO_DIR status
git -C $PANTHEON_REPO_DIR rm -fr .
git -C $PANTHEON_REPO_DIR status

