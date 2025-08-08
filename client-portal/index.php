<?php
/**
 * KTP Digital Client Portal
 * Integrated with existing webstack
 */

// Check if user is authenticated (integrate with existing auth system)
session_start();

// For demo purposes, we'll allow access
// In production, integrate with your existing authentication system
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KTP Digital - Client Portal</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">KTP Digital Automation Portal</h1>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Automation Status</h2>
            <div id="status-container">
                <p>Loading...</p>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6 mt-8">
            <h2 class="text-xl font-semibold mb-4">Quick Actions</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <button onclick="runJob('health_check')" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Health Check
                </button>
                <button onclick="runJob('security_scan')" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    Security Scan
                </button>
                <button onclick="runJob('backup_verify')" class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600">
                    Backup Verify
                </button>
            </div>
        </div>
    </div>
    
    <script>
        async function loadStatus() {
            try {
                const response = await fetch('/automation/api/status');
                const data = await response.json();
                
                document.getElementById('status-container').innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">${data.jobs.processing}</div>
                            <div class="text-sm text-gray-600">Processing</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-600">${data.jobs.queued}</div>
                            <div class="text-sm text-gray-600">Queued</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">${data.jobs.completed}</div>
                            <div class="text-sm text-gray-600">Completed</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-red-600">${data.jobs.failed}</div>
                            <div class="text-sm text-gray-600">Failed</div>
                        </div>
                    </div>
                `;
            } catch (error) {
                document.getElementById('status-container').innerHTML = '<p class="text-red-600">Failed to load status</p>';
            }
        }
        
        async function runJob(jobType) {
            try {
                const response = await fetch('/automation/api/jobs', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        client_id: 'portal_user',
                        job_type: jobType,
                        parameters: {}
                    })
                });
                
                const result = await response.json();
                if (result.success) {
                    alert(`Job queued successfully: ${result.job_id}`);
                    setTimeout(loadStatus, 1000);
                } else {
                    alert('Failed to queue job');
                }
            } catch (error) {
                alert('Error queuing job');
            }
        }
        
        // Load status on page load and refresh every 30 seconds
        loadStatus();
        setInterval(loadStatus, 30000);
    </script>
</body>
</html>
