<?php
// Simple authentication check
$page = 'screenshot_upload';
session_start();
require_once __DIR__ . '/admin_auth.php';

// Handle file uploads
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = '/opt/webstack/screenshots/';
    $response = ['success' => false, 'message' => '', 'files' => []];
    
    $uploadedFiles = [];
    
    // Handle the 'screenshot' field with array notation
    if (isset($_FILES['screenshot'])) {
        $files = $_FILES['screenshot'];
        
        // Handle multiple files
        if (is_array($files['name'])) {
            for ($i = 0; $i < count($files['name']); $i++) {
                if ($files['error'][$i] === UPLOAD_ERR_OK) {
                    $timestamp = date('Ymd-His');
                    $extension = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
                    $filename = "screenshot-{$timestamp}-{$i}.{$extension}";
                    $filepath = $uploadDir . $filename;
                    
                    if (move_uploaded_file($files['tmp_name'][$i], $filepath)) {
                        $uploadedFiles[] = $filename;
                    }
                }
            }
        } else {
            // Single file
            if ($files['error'] === UPLOAD_ERR_OK) {
                $timestamp = date('Ymd-His');
                $extension = pathinfo($files['name'], PATHINFO_EXTENSION);
                $filename = "screenshot-{$timestamp}.{$extension}";
                $filepath = $uploadDir . $filename;
                
                if (move_uploaded_file($files['tmp_name'], $filepath)) {
                    $uploadedFiles[] = $filename;
                }
            }
        }
    }
    
    if (count($uploadedFiles) > 0) {
        $response['success'] = true;
        $response['message'] = 'Screenshots uploaded successfully';
        $response['files'] = $uploadedFiles;
    } else {
        $response['message'] = 'Failed to upload screenshots';
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Get list of existing screenshots
$screenshots = [];
if (is_dir('/opt/webstack/screenshots')) {
    $files = scandir('/opt/webstack/screenshots');
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..' && preg_match('/\.(png|jpg|jpeg|gif|webp|mov|mp4|pdf)$/i', $file)) {
            $filepath = '/opt/webstack/screenshots/' . $file;
            $screenshots[] = [
                'name' => $file,
                'size' => filesize($filepath),
                'time' => filemtime($filepath),
                'timeFormatted' => date('Y-m-d H:i:s', filemtime($filepath))
            ];
        }
    }
    // Sort by time, newest first
    usort($screenshots, function($a, $b) {
        return $b['time'] - $a['time'];
    });
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Screenshot Upload - KTP Digital Admin</title>
    <link rel="stylesheet" href="/assets/tailwind.min.css">
    <script src="https://cdn.tailwindcss.com/3.4.0"></script>
    <style>
        .drop-zone {
            transition: all 0.3s ease;
            border: 4px dashed #d1d5db !important;
            border-radius: 0.5rem !important;
            padding: 3rem !important;
            text-align: center !important;
            cursor: pointer !important;
        }
        .drop-zone:hover {
            border-color: #60a5fa !important;
        }
        .drop-zone.dragover {
            background-color: rgb(59, 130, 246, 0.1);
            border-color: rgb(59, 130, 246);
            transform: scale(1.02);
        }
        .uploading {
            opacity: 0.6;
            pointer-events: none;
        }
        .btn-primary {
            background-color: #3b82f6 !important;
            color: white !important;
            padding: 0.5rem 1.5rem !important;
            border-radius: 0.5rem !important;
            font-weight: 600 !important;
            transition: background-color 0.3s ease !important;
        }
        .btn-primary:hover {
            background-color: #2563eb !important;
        }
    </style>
</head>
<body class="bg-gray-50">
    <?php include 'admin_nav.php'; ?>
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Screenshot Upload</h1>
            
            <!-- Drop Zone -->
            <div id="dropZone" class="drop-zone border-4 border-dashed border-gray-300 rounded-lg p-12 text-center cursor-pointer hover:border-blue-400 transition-colors">
                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                <p class="text-xl font-semibold text-gray-700 mb-2">Drop files here</p>
                <p class="text-gray-500 mb-4">Images, videos (.mov, .mp4), or PDFs</p>
                <input type="file" id="fileInput" class="hidden" multiple accept="image/*,.mov,.mp4,.pdf">
                <button onclick="document.getElementById('fileInput').click()" class="btn-primary">
                    Choose Files
                </button>
            </div>
            
            <!-- Upload Status -->
            <div id="uploadStatus" class="mt-6 hidden">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    <p class="font-semibold">Upload successful!</p>
                    <p id="uploadedFiles" class="text-sm mt-1"></p>
                </div>
            </div>
            
            <!-- Error Status -->
            <div id="errorStatus" class="mt-6 hidden">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <p class="font-semibold">Upload failed!</p>
                    <p id="errorMessage" class="text-sm mt-1"></p>
                </div>
            </div>
            
            <!-- Recent Screenshots -->
            <div class="mt-8">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Recent Screenshots</h2>
                <?php if (count($screenshots) > 0): ?>
                <div class="bg-gray-100 rounded-lg p-4 max-h-64 overflow-y-auto">
                    <ul class="space-y-2">
                        <?php foreach (array_slice($screenshots, 0, 10) as $screenshot): ?>
                        <li class="flex justify-between items-center bg-white rounded px-3 py-2">
                            <span class="text-sm font-mono text-gray-700"><?php echo htmlspecialchars($screenshot['name']); ?></span>
                            <span class="text-xs text-gray-500"><?php echo $screenshot['timeFormatted']; ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php if (count($screenshots) > 10): ?>
                    <p class="text-sm text-gray-500 mt-2">... and <?php echo count($screenshots) - 10; ?> more</p>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                <p class="text-gray-500">No screenshots uploaded yet</p>
                <?php endif; ?>
            </div>
            
            <!-- Instructions -->
            <div class="mt-8 p-4 bg-blue-50 rounded-lg">
                <h3 class="font-semibold text-blue-900 mb-2">Quick Upload Methods:</h3>
                <ul class="text-sm text-blue-800 space-y-1">
                    <li>• <strong>Drag & Drop:</strong> Drag screenshots directly onto the upload area</li>
                    <li>• <strong>SCP:</strong> <code class="bg-white px-2 py-1 rounded">scp screenshot.png root@server:/opt/webstack/screenshots/</code></li>
                    <li>• <strong>Claude Code:</strong> Tell Claude "look at /opt/webstack/screenshots/screenshot-*.png"</li>
                </ul>
            </div>
        </div>
    </div>
    
    <script>
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const uploadStatus = document.getElementById('uploadStatus');
        const errorStatus = document.getElementById('errorStatus');
        const uploadedFiles = document.getElementById('uploadedFiles');
        const errorMessage = document.getElementById('errorMessage');
        
        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });
        
        // Highlight drop zone when item is dragged over it
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });
        
        // Handle dropped files
        dropZone.addEventListener('drop', handleDrop, false);
        fileInput.addEventListener('change', handleFileSelect, false);
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        function highlight(e) {
            dropZone.classList.add('dragover');
        }
        
        function unhighlight(e) {
            dropZone.classList.remove('dragover');
        }
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            uploadFiles(files);
        }
        
        function handleFileSelect(e) {
            const files = e.target.files;
            uploadFiles(files);
        }
        
        function uploadFiles(files) {
            // Hide previous status messages
            uploadStatus.classList.add('hidden');
            errorStatus.classList.add('hidden');
            
            // Add uploading state
            dropZone.classList.add('uploading');
            
            const formData = new FormData();
            // Always use 'screenshot' field name with array notation for consistency
            for (let i = 0; i < files.length; i++) {
                formData.append('screenshot[]', files[i]);
            }
            
            fetch('/admin/screenshot-upload.php', {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'  // Include cookies for authentication
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                dropZone.classList.remove('uploading');
                if (data.success) {
                    uploadStatus.classList.remove('hidden');
                    uploadedFiles.textContent = 'Uploaded: ' + data.files.join(', ');
                    // Reload page after 2 seconds to show new screenshots
                    setTimeout(() => location.reload(), 2000);
                } else {
                    errorStatus.classList.remove('hidden');
                    errorMessage.textContent = data.message;
                }
            })
            .catch(error => {
                dropZone.classList.remove('uploading');
                errorStatus.classList.remove('hidden');
                errorMessage.textContent = 'Network error: ' + error.message;
            });
        }
    </script>
</body>
</html>