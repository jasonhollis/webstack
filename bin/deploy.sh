#!/bin/bash
set -e

VERSION="$1"
if [ -z "$VERSION" ]; then
  echo "❌ Usage: ./deploy.sh <version-tag>"
  exit 1
fi

echo "$VERSION" > /opt/webstack/html/VERSION
cd /opt/webstack/html

echo "📦 Committing version $VERSION"
git add VERSION
git commit -m "🚀 Deploy $VERSION"
git push origin master

echo "✅ Deployment complete."
