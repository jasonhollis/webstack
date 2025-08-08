#!/bin/bash

# KTP Digital Integration Tests
# Verifies that automation is working alongside existing webstack

echo "=== KTP DIGITAL INTEGRATION TESTS ==="

# Test 1: Database connectivity
echo "Testing database connectivity..."
php -r "
require '/opt/webstack/automation/config/integration.php';
try {
    \$pdo = new PDO(
        sprintf('mysql:host=%s;dbname=%s', AUTOMATION_DB_HOST, AUTOMATION_DB_NAME),
        AUTOMATION_DB_USER,
        AUTOMATION_DB_PASS
    );
    echo 'Database connection: ✅ SUCCESS\n';
} catch (Exception \$e) {
    echo 'Database connection: ❌ FAILED - ' . \$e->getMessage() . '\n';
}
"

# Test 2: Redis connectivity
echo "Testing Redis connectivity..."
php -r "
\$redis = new Redis();
if (\$redis->connect('127.0.0.1', 6379)) {
    echo 'Redis connection: ✅ SUCCESS\n';
} else {
    echo 'Redis connection: ❌ FAILED\n';
}
"

# Test 3: Automation API
echo "Testing automation API..."
response=$(curl -s -w "%{http_code}" http://localhost/automation/api/health -o /tmp/api_test.json)
if [ "$response" = "200" ]; then
    echo "Automation API: ✅ SUCCESS"
    echo "Response: $(cat /tmp/api_test.json)"
else
    echo "Automation API: ❌ FAILED (HTTP $response)"
fi

# Test 4: Client Portal
echo "Testing client portal..."
response=$(curl -s -w "%{http_code}" http://localhost/portal/ -o /dev/null)
if [ "$response" = "200" ]; then
    echo "Client Portal: ✅ SUCCESS"
else
    echo "Client Portal: ❌ FAILED (HTTP $response)"
fi

# Test 5: Job queueing
echo "Testing job queueing..."
job_response=$(curl -s -X POST \
    -H "Content-Type: application/json" \
    -d '{"client_id":"test","job_type":"health_check","parameters":{}}' \
    http://localhost/automation/api/jobs)

if echo "$job_response" | grep -q '"success":true'; then
    echo "Job queueing: ✅ SUCCESS"
    echo "Response: $job_response"
else
    echo "Job queueing: ❌ FAILED"
    echo "Response: $job_response"
fi

echo ""
echo "Integration tests completed!"
