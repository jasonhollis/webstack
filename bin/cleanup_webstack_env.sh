#!/bin/bash

echo "🧹 Starting full Webstack cleanup..."

# 1. Remove old test/dev directories
rm -rf /opt/webstack-test /opt/webstack-dev
echo "✅ Removed /opt/webstack-test and /opt/webstack-dev"

# 2. Remove test/dev-related files inside html
find /opt/webstack/html -iname '*test*' -exec rm -v {} \;

# 3. Remove logs and snapshots related to test/dev
rm -f /opt/webstack/logs/*test*.log
rm -f /opt/webstack/snapshots/*test*.zip
echo "✅ Cleaned logs and snapshots"

# 4. Remove old test PHP files or test routes
rm -f /opt/webstack/html/test.php /opt/webstack/html/dev.php
rm -rf /opt/webstack/html/test /opt/webstack/html/dev
echo "✅ Removed test/dev PHP endpoints and folders"

# 5. Remove test webhook service if it exists
systemctl stop webstack_test_webhook.service 2>/dev/null
systemctl disable webstack_test_webhook.service 2>/dev/null
rm -f /etc/systemd/system/webstack_test_webhook.service
echo "✅ Removed webstack_test_webhook.service if it was present"

# 6. Cleanup any .gitignore exclusions that reference test/dev
sed -i '/test/d;/dev/d' /opt/webstack/html/.gitignore

echo "✅ Cleanup complete."
