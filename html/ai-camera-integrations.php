<?php
require_once __DIR__ . '/layout.php';

$page_title = 'AI Camera Integrations | Advanced Security & Detection | KTP Digital';
$page_description = 'Enterprise-grade AI camera integrations with Home Assistant. Object detection, facial recognition, and intelligent security for Melbourne\'s premium properties.';

ob_start();
?>

<style>
    .comparison-table {
        overflow-x: auto;
    }
    .comparison-table table {
        min-width: 800px;
    }
    .comparison-table th {
        background: linear-gradient(135deg, #1e40af 0%, #0891b2 100%);
        color: white;
        padding: 1rem;
        text-align: left;
        font-weight: 600;
    }
    .comparison-table td {
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
    }
    .comparison-table tr:hover {
        background: #f9fafb;
    }
    .feature-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 600;
    }
    .badge-local {
        background: #dcfce7;
        color: #166534;
    }
    .badge-cloud {
        background: #fef3c7;
        color: #92400e;
    }
    .badge-easy {
        background: #dbeafe;
        color: #1e40af;
    }
    .badge-advanced {
        background: #fce7f3;
        color: #9f1239;
    }
    .integration-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
    }
    .integration-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
    }
</style>

<div class="max-w-7xl mx-auto px-4 py-12">
    <!-- Hero Section -->
    <div class="text-center mb-12">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full mb-6">
            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
            </svg>
        </div>
        <h1 class="text-4xl md:text-5xl font-bold mb-4">AI Camera Integrations</h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Transform your security cameras into intelligent guardians with AI-powered object detection, facial recognition, and real-time alerts
        </p>
    </div>

    <!-- Key Benefits -->
    <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-2xl p-8 mb-12">
        <h2 class="text-2xl font-bold mb-6 text-center">Why AI-Powered Security?</h2>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="text-3xl mb-3">🎯</div>
                <h3 class="font-bold mb-2">Accurate Detection</h3>
                <p class="text-gray-700">Distinguish between people, vehicles, packages, and animals. No more false alarms from shadows or trees.</p>
            </div>
            <div class="text-center">
                <div class="text-3xl mb-3">👤</div>
                <h3 class="font-bold mb-2">Facial Recognition</h3>
                <p class="text-gray-700">Identify family members vs strangers. Automatic door unlocking for trusted faces.</p>
            </div>
            <div class="text-center">
                <div class="text-3xl mb-3">⚡</div>
                <h3 class="font-bold mb-2">Instant Alerts</h3>
                <p class="text-gray-700">Real-time notifications with snapshots when specific objects or people are detected.</p>
            </div>
        </div>
    </div>

    <!-- Object Detection & AI Analysis -->
    <section class="mb-16">
        <h2 class="text-3xl font-bold mb-8">🤖 Object Detection & AI Analysis</h2>
        
        <div class="grid md:grid-cols-2 gap-6 mb-8">
            <!-- Frigate -->
            <div class="integration-card">
                <div class="flex items-start justify-between mb-4">
                    <h3 class="text-xl font-bold">Frigate</h3>
                    <span class="feature-badge badge-local">Local</span>
                </div>
                <p class="text-gray-600 mb-4">The gold standard for Home Assistant camera AI. Real-time object detection with hardware acceleration.</p>
                <div class="space-y-2 text-sm">
                    <div><strong>Features:</strong> 24/7 recording, zones, Coral TPU/GPU support</div>
                    <div><strong>Best for:</strong> Comprehensive security systems</div>
                    <div><strong>Difficulty:</strong> <span class="feature-badge badge-advanced">Advanced</span></div>
                </div>
                <div class="mt-4 pt-4 border-t">
                    <a href="https://github.com/blakeblackshear/frigate" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm">
                        View Documentation →
                    </a>
                </div>
            </div>

            <!-- CodeProject.AI -->
            <div class="integration-card">
                <div class="flex items-start justify-between mb-4">
                    <h3 class="text-xl font-bold">CodeProject.AI</h3>
                    <span class="feature-badge badge-local">Local</span>
                </div>
                <p class="text-gray-600 mb-4">User-friendly AI server with web UI. Perfect for beginners wanting powerful local AI.</p>
                <div class="space-y-2 text-sm">
                    <div><strong>Features:</strong> Multiple AI models, easy web UI, GPU support</div>
                    <div><strong>Best for:</strong> Beginners wanting local AI</div>
                    <div><strong>Difficulty:</strong> <span class="feature-badge badge-easy">Easy</span></div>
                </div>
                <div class="mt-4 pt-4 border-t">
                    <a href="https://www.codeproject.com/ai" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm">
                        View Documentation →
                    </a>
                </div>
            </div>

            <!-- DeepStack -->
            <div class="integration-card">
                <div class="flex items-start justify-between mb-4">
                    <h3 class="text-xl font-bold">DeepStack</h3>
                    <span class="feature-badge badge-local">Local</span>
                </div>
                <p class="text-gray-600 mb-4">Self-hosted AI server with object detection, face recognition, and scene analysis.</p>
                <div class="space-y-2 text-sm">
                    <div><strong>Features:</strong> Object/face/scene recognition</div>
                    <div><strong>Best for:</strong> Simple object detection</div>
                    <div><strong>Difficulty:</strong> <span class="feature-badge badge-easy">Intermediate</span></div>
                </div>
                <div class="mt-4 pt-4 border-t">
                    <code class="text-xs bg-gray-100 px-2 py-1 rounded">deepquestai/deepstack</code>
                </div>
            </div>

            <!-- DOODS2 -->
            <div class="integration-card">
                <div class="flex items-start justify-between mb-4">
                    <h3 class="text-xl font-bold">DOODS2</h3>
                    <span class="feature-badge badge-local">Local</span>
                </div>
                <p class="text-gray-600 mb-4">Distributed object detection with support for custom models and multiple detectors.</p>
                <div class="space-y-2 text-sm">
                    <div><strong>Features:</strong> TensorFlow/PyTorch, REST API</div>
                    <div><strong>Best for:</strong> Custom detection models</div>
                    <div><strong>Difficulty:</strong> <span class="feature-badge badge-easy">Intermediate</span></div>
                </div>
                <div class="mt-4 pt-4 border-t">
                    <a href="https://github.com/snowzach/doods2" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm">
                        View Documentation →
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Cloud AI Services -->
    <section class="mb-16">
        <h2 class="text-3xl font-bold mb-8">☁️ Cloud AI Services</h2>
        
        <div class="bg-amber-50 border-l-4 border-amber-400 p-4 mb-6">
            <p class="text-amber-800">
                <strong>Privacy Note:</strong> Cloud services process images externally. Ideal for non-sensitive areas or when local processing isn't feasible.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <!-- Amazon Rekognition -->
            <div class="integration-card">
                <div class="flex items-start justify-between mb-4">
                    <h3 class="text-xl font-bold">Amazon Rekognition</h3>
                    <span class="feature-badge badge-cloud">Cloud</span>
                </div>
                <p class="text-gray-600 mb-4">AWS-powered detection with celebrity recognition and text extraction.</p>
                <div class="space-y-2 text-sm">
                    <div><strong>Features:</strong> Object/face/text/celebrity detection</div>
                    <div><strong>Cost:</strong> Pay-per-use</div>
                    <div><strong>Privacy:</strong> Images sent to AWS</div>
                </div>
            </div>

            <!-- Google Vision AI -->
            <div class="integration-card">
                <div class="flex items-start justify-between mb-4">
                    <h3 class="text-xl font-bold">Google Vision AI</h3>
                    <span class="feature-badge badge-cloud">Cloud</span>
                </div>
                <p class="text-gray-600 mb-4">Google's powerful vision API with landmark detection and OCR.</p>
                <div class="space-y-2 text-sm">
                    <div><strong>Features:</strong> Object/landmark/text detection</div>
                    <div><strong>Cost:</strong> Pay-per-use</div>
                    <div><strong>Privacy:</strong> Images sent to Google</div>
                </div>
            </div>

            <!-- Azure Cognitive -->
            <div class="integration-card">
                <div class="flex items-start justify-between mb-4">
                    <h3 class="text-xl font-bold">Azure Cognitive Services</h3>
                    <span class="feature-badge badge-cloud">Cloud</span>
                </div>
                <p class="text-gray-600 mb-4">Microsoft's computer vision with custom model training capabilities.</p>
                <div class="space-y-2 text-sm">
                    <div><strong>Features:</strong> Computer vision, custom models</div>
                    <div><strong>Cost:</strong> Pay-per-use</div>
                    <div><strong>Privacy:</strong> Images sent to Microsoft</div>
                </div>
            </div>
        </div>
    </section>

    <!-- NVR Solutions -->
    <section class="mb-16">
        <h2 class="text-3xl font-bold mb-8">📹 NVR Solutions with Motion Detection</h2>
        
        <div class="grid md:grid-cols-3 gap-6">
            <!-- MotionEye -->
            <div class="integration-card">
                <h3 class="text-xl font-bold mb-3">MotionEye</h3>
                <p class="text-gray-600 mb-4">Lightweight NVR perfect for simple motion-triggered recording.</p>
                <div class="space-y-2 text-sm">
                    <div><strong>Features:</strong> Motion detection, webhooks</div>
                    <div><strong>Difficulty:</strong> <span class="feature-badge badge-easy">Easy</span></div>
                    <div><strong>Resource Usage:</strong> Low</div>
                </div>
            </div>

            <!-- Shinobi -->
            <div class="integration-card">
                <h3 class="text-xl font-bold mb-3">Shinobi</h3>
                <p class="text-gray-600 mb-4">Open-source NVR with plugins and API for traditional surveillance needs.</p>
                <div class="space-y-2 text-sm">
                    <div><strong>Features:</strong> Motion detection, plugins, API</div>
                    <div><strong>Difficulty:</strong> <span class="feature-badge badge-easy">Intermediate</span></div>
                    <div><strong>Resource Usage:</strong> Medium</div>
                </div>
            </div>

            <!-- ZoneMinder -->
            <div class="integration-card">
                <h3 class="text-xl font-bold mb-3">ZoneMinder</h3>
                <p class="text-gray-600 mb-4">Enterprise-style surveillance system with comprehensive analysis.</p>
                <div class="space-y-2 text-sm">
                    <div><strong>Features:</strong> Analysis, events, API</div>
                    <div><strong>Difficulty:</strong> <span class="feature-badge badge-advanced">Advanced</span></div>
                    <div><strong>Resource Usage:</strong> High</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Comparison Table -->
    <section class="mb-16">
        <h2 class="text-3xl font-bold mb-8">📊 Quick Comparison</h2>
        
        <div class="comparison-table bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr>
                        <th>Integration</th>
                        <th>Local/Cloud</th>
                        <th>GPU Support</th>
                        <th>Coral TPU</th>
                        <th>Setup Difficulty</th>
                        <th>Resource Usage</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="font-medium">Frigate</td>
                        <td><span class="feature-badge badge-local">Local</span></td>
                        <td>✅ Yes</td>
                        <td>✅ Yes</td>
                        <td><span class="text-red-600">High</span></td>
                        <td>Low-Medium</td>
                    </tr>
                    <tr>
                        <td class="font-medium">DeepStack</td>
                        <td><span class="feature-badge badge-local">Local</span></td>
                        <td>✅ Yes</td>
                        <td>❌ No</td>
                        <td><span class="text-yellow-600">Medium</span></td>
                        <td>High</td>
                    </tr>
                    <tr>
                        <td class="font-medium">CodeProject.AI</td>
                        <td><span class="feature-badge badge-local">Local</span></td>
                        <td>✅ Yes</td>
                        <td>❌ No</td>
                        <td><span class="text-green-600">Low</span></td>
                        <td>Medium</td>
                    </tr>
                    <tr>
                        <td class="font-medium">DOODS2</td>
                        <td><span class="feature-badge badge-local">Local</span></td>
                        <td>✅ Yes</td>
                        <td>❌ No</td>
                        <td><span class="text-yellow-600">Medium</span></td>
                        <td>Medium</td>
                    </tr>
                    <tr>
                        <td class="font-medium">TensorFlow</td>
                        <td><span class="feature-badge badge-local">Local</span></td>
                        <td>❌ No</td>
                        <td>❌ No</td>
                        <td><span class="text-green-600">Low</span></td>
                        <td>Low</td>
                    </tr>
                    <tr>
                        <td class="font-medium">Amazon Rekognition</td>
                        <td><span class="feature-badge badge-cloud">Cloud</span></td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td><span class="text-green-600">Low</span></td>
                        <td>None</td>
                    </tr>
                    <tr>
                        <td class="font-medium">Google Vision</td>
                        <td><span class="feature-badge badge-cloud">Cloud</span></td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td><span class="text-green-600">Low</span></td>
                        <td>None</td>
                    </tr>
                    <tr>
                        <td class="font-medium">MotionEye</td>
                        <td><span class="feature-badge badge-local">Local</span></td>
                        <td>❌ No</td>
                        <td>❌ No</td>
                        <td><span class="text-green-600">Low</span></td>
                        <td>Low</td>
                    </tr>
                    <tr>
                        <td class="font-medium">ZoneMinder</td>
                        <td><span class="feature-badge badge-local">Local</span></td>
                        <td>✅ Yes</td>
                        <td>❌ No</td>
                        <td><span class="text-red-600">High</span></td>
                        <td>High</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Real-World Applications -->
    <section class="mb-16">
        <h2 class="text-3xl font-bold mb-8">🏠 Real-World Applications</h2>
        
        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-blue-50 rounded-lg p-6">
                <h3 class="text-xl font-bold mb-4">Toorak Estate Implementation</h3>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <span class="text-green-600 mr-2">✓</span>
                        <span>Frigate with Coral TPU processing 16 UniFi cameras</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-green-600 mr-2">✓</span>
                        <span>Facial recognition for automatic gate and door entry</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-green-600 mr-2">✓</span>
                        <span>Package detection with instant notifications</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-green-600 mr-2">✓</span>
                        <span>Wildlife filtering to prevent false alarms</span>
                    </li>
                </ul>
            </div>
            
            <div class="bg-green-50 rounded-lg p-6">
                <h3 class="text-xl font-bold mb-4">Brighton Business Implementation</h3>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <span class="text-green-600 mr-2">✓</span>
                        <span>CodeProject.AI for visitor identification</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-green-600 mr-2">✓</span>
                        <span>License plate recognition for parking management</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-green-600 mr-2">✓</span>
                        <span>After-hours intrusion detection with alerts</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-green-600 mr-2">✓</span>
                        <span>Integration with access control systems</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Automation Platforms -->
    <section class="mb-16">
        <h2 class="text-3xl font-bold mb-8">⚙️ Automation Platforms</h2>
        
        <div class="grid md:grid-cols-2 gap-6">
            <div class="integration-card">
                <h3 class="text-xl font-bold mb-3">Node-RED</h3>
                <p class="text-gray-600 mb-4">Visual flow-based programming for complex automation workflows.</p>
                <div class="space-y-2 text-sm">
                    <div><strong>Features:</strong> Visual programming, HTTP endpoints</div>
                    <div><strong>Best for:</strong> Complex automation workflows</div>
                    <div><strong>Difficulty:</strong> Intermediate</div>
                </div>
            </div>

            <div class="integration-card">
                <h3 class="text-xl font-bold mb-3">AppDaemon</h3>
                <p class="text-gray-600 mb-4">Python framework for advanced automation with OpenCV support.</p>
                <div class="space-y-2 text-sm">
                    <div><strong>Features:</strong> Python apps, OpenCV, scheduling</div>
                    <div><strong>Best for:</strong> Custom Python-based detection</div>
                    <div><strong>Difficulty:</strong> Advanced</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-gradient-to-r from-blue-600 to-cyan-500 rounded-2xl p-12 text-white text-center">
        <h2 class="text-3xl font-bold mb-4">Ready for Intelligent Security?</h2>
        <p class="text-xl mb-8">Let us design an AI-powered camera system that actually protects what matters</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/premium-landing-spiral.php#contact" class="inline-block bg-white text-blue-600 px-8 py-4 rounded-lg font-bold hover:bg-gray-100 transition">
                Schedule Consultation
            </a>
            <a href="/integrations.php?category=security" class="inline-block bg-blue-700 text-white px-8 py-4 rounded-lg font-bold hover:bg-blue-800 transition">
                View Security Integrations
            </a>
        </div>
    </section>
</div>

<?php
$content = ob_get_clean();

echo renderLayout(
    $page_title,
    $content,
    '',
    $page_description,
    '/ai-camera-integrations.php'
);
?>