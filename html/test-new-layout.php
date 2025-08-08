<?php
// Page configuration
$page_title = "Test Page | KTP Digital";
$page_desc = "Testing the new layout system";
$dark_mode = true;
$use_bank_gothic = true;

// Start capturing content
ob_start();
?>

<div class="container mx-auto px-4 py-12">
    <h1 class="bank-gothic text-4xl md:text-6xl mb-8 text-white text-center">
        Test Page
    </h1>
    
    <div class="bg-slate-800 rounded-xl p-8 text-white">
        <h2 class="text-2xl font-bold mb-4">Layout System Working!</h2>
        <p class="mb-4">This page demonstrates the new layout system with:</p>
        <ul class="list-disc list-inside space-y-2">
            <li>✅ Navigation from nav.php</li>
            <li>✅ Cookie acceptance banner</li>
            <li>✅ Analytics logging</li>
            <li>✅ Dark mode support</li>
            <li>✅ Bank Gothic font</li>
            <li>✅ Modern footer</li>
        </ul>
    </div>
    
    <div class="mt-8 grid md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-blue-600 to-cyan-500 rounded-xl p-6 text-white">
            <h3 class="font-bold text-xl mb-2">Service 1</h3>
            <p>Example service card</p>
        </div>
        <div class="bg-gradient-to-br from-blue-600 to-cyan-500 rounded-xl p-6 text-white">
            <h3 class="font-bold text-xl mb-2">Service 2</h3>
            <p>Example service card</p>
        </div>
        <div class="bg-gradient-to-br from-blue-600 to-cyan-500 rounded-xl p-6 text-white">
            <h3 class="font-bold text-xl mb-2">Service 3</h3>
            <p>Example service card</p>
        </div>
    </div>
</div>

<?php
// Get the content
$content = ob_get_clean();

// Include the layout
require_once __DIR__ . '/layout-new.php';
?>