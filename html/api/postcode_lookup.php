<?php
/**
 * Australian Postcode/Suburb Lookup API
 * Uses multiple fallback sources for reliability
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Get request parameters
$postcode = isset($_GET['postcode']) ? trim($_GET['postcode']) : '';
$suburb = isset($_GET['suburb']) ? trim($_GET['suburb']) : '';

// Validate input
if (empty($postcode) && empty($suburb)) {
    echo json_encode(['error' => 'Please provide either postcode or suburb parameter']);
    exit;
}

// Initialize response
$response = [];

// Function to fetch from postcodeapi.com.au (primary source)
function fetchFromPostcodeAPI($postcode = '', $suburb = '') {
    $results = [];
    
    try {
        if (!empty($postcode)) {
            // Lookup by postcode
            $url = "http://v0.postcodeapi.com.au/suburbs/{$postcode}.json";
            $data = @file_get_contents($url);
            
            if ($data !== false) {
                $json = json_decode($data, true);
                if (is_array($json)) {
                    foreach ($json as $item) {
                        $results[] = [
                            'postcode' => $item['postcode'] ?? $postcode,
                            'suburb' => $item['name'] ?? '',
                            'state' => $item['state']['abbreviation'] ?? '',
                            'latitude' => $item['latitude'] ?? null,
                            'longitude' => $item['longitude'] ?? null
                        ];
                    }
                }
            }
        } elseif (!empty($suburb)) {
            // Search by suburb name - using search endpoint
            $url = "http://v0.postcodeapi.com.au/suburbs.json?q=" . urlencode($suburb);
            $data = @file_get_contents($url);
            
            if ($data !== false) {
                $json = json_decode($data, true);
                if (is_array($json)) {
                    foreach ($json as $item) {
                        $results[] = [
                            'postcode' => $item['postcode'] ?? '',
                            'suburb' => $item['name'] ?? '',
                            'state' => $item['state']['abbreviation'] ?? '',
                            'latitude' => $item['latitude'] ?? null,
                            'longitude' => $item['longitude'] ?? null
                        ];
                    }
                }
            }
        }
    } catch (Exception $e) {
        // Silently fail and return empty results
    }
    
    return $results;
}

// Function for fallback: static Victorian postcodes (common ones)
function getStaticVictorianPostcodes($postcode = '', $suburb = '') {
    $vic_postcodes = [
        // Melbourne CBD and surrounds
        ['postcode' => '3000', 'suburb' => 'Melbourne', 'state' => 'VIC'],
        ['postcode' => '3006', 'suburb' => 'Southbank', 'state' => 'VIC'],
        ['postcode' => '3008', 'suburb' => 'Docklands', 'state' => 'VIC'],
        
        // Premium suburbs
        ['postcode' => '3141', 'suburb' => 'South Yarra', 'state' => 'VIC'],
        ['postcode' => '3142', 'suburb' => 'Toorak', 'state' => 'VIC'],
        ['postcode' => '3143', 'suburb' => 'Armadale', 'state' => 'VIC'],
        ['postcode' => '3144', 'suburb' => 'Malvern', 'state' => 'VIC'],
        ['postcode' => '3181', 'suburb' => 'Prahran', 'state' => 'VIC'],
        ['postcode' => '3186', 'suburb' => 'Brighton', 'state' => 'VIC'],
        ['postcode' => '3187', 'suburb' => 'Brighton East', 'state' => 'VIC'],
        ['postcode' => '3121', 'suburb' => 'Richmond', 'state' => 'VIC'],
        ['postcode' => '3122', 'suburb' => 'Hawthorn', 'state' => 'VIC'],
        ['postcode' => '3123', 'suburb' => 'Camberwell', 'state' => 'VIC'],
        ['postcode' => '3124', 'suburb' => 'Canterbury', 'state' => 'VIC'],
        ['postcode' => '3126', 'suburb' => 'Canterbury', 'state' => 'VIC'],
        ['postcode' => '3101', 'suburb' => 'Kew', 'state' => 'VIC'],
        ['postcode' => '3103', 'suburb' => 'Balwyn', 'state' => 'VIC'],
        
        // Eastern suburbs
        ['postcode' => '3131', 'suburb' => 'Nunawading', 'state' => 'VIC'],
        ['postcode' => '3132', 'suburb' => 'Mitcham', 'state' => 'VIC'],
        ['postcode' => '3133', 'suburb' => 'Vermont', 'state' => 'VIC'],
        ['postcode' => '3134', 'suburb' => 'Ringwood', 'state' => 'VIC'],
        
        // Northern suburbs
        ['postcode' => '3070', 'suburb' => 'Northcote', 'state' => 'VIC'],
        ['postcode' => '3071', 'suburb' => 'Thornbury', 'state' => 'VIC'],
        ['postcode' => '3072', 'suburb' => 'Preston', 'state' => 'VIC'],
        
        // Western suburbs
        ['postcode' => '3011', 'suburb' => 'Footscray', 'state' => 'VIC'],
        ['postcode' => '3012', 'suburb' => 'West Footscray', 'state' => 'VIC'],
        ['postcode' => '3015', 'suburb' => 'Newport', 'state' => 'VIC'],
        ['postcode' => '3016', 'suburb' => 'Williamstown', 'state' => 'VIC'],
        
        // Bayside
        ['postcode' => '3182', 'suburb' => 'St Kilda', 'state' => 'VIC'],
        ['postcode' => '3183', 'suburb' => 'St Kilda East', 'state' => 'VIC'],
        ['postcode' => '3184', 'suburb' => 'Elwood', 'state' => 'VIC'],
        ['postcode' => '3185', 'suburb' => 'Elsternwick', 'state' => 'VIC'],
        ['postcode' => '3188', 'suburb' => 'Hampton', 'state' => 'VIC'],
        ['postcode' => '3191', 'suburb' => 'Sandringham', 'state' => 'VIC'],
        ['postcode' => '3193', 'suburb' => 'Beaumaris', 'state' => 'VIC'],
        ['postcode' => '3194', 'suburb' => 'Mentone', 'state' => 'VIC'],
        ['postcode' => '3195', 'suburb' => 'Mordialloc', 'state' => 'VIC'],
        
        // South Eastern
        ['postcode' => '3145', 'suburb' => 'Caulfield', 'state' => 'VIC'],
        ['postcode' => '3161', 'suburb' => 'Caulfield North', 'state' => 'VIC'],
        ['postcode' => '3162', 'suburb' => 'Caulfield South', 'state' => 'VIC'],
        ['postcode' => '3163', 'suburb' => 'Carnegie', 'state' => 'VIC'],
        ['postcode' => '3165', 'suburb' => 'Bentleigh', 'state' => 'VIC'],
        ['postcode' => '3166', 'suburb' => 'Oakleigh', 'state' => 'VIC'],
        ['postcode' => '3167', 'suburb' => 'Oakleigh South', 'state' => 'VIC'],
        ['postcode' => '3168', 'suburb' => 'Clayton', 'state' => 'VIC'],
        ['postcode' => '3169', 'suburb' => 'Clarinda', 'state' => 'VIC'],
        ['postcode' => '3170', 'suburb' => 'Mulgrave', 'state' => 'VIC'],
        ['postcode' => '3171', 'suburb' => 'Springvale', 'state' => 'VIC'],
        ['postcode' => '3172', 'suburb' => 'Keysborough', 'state' => 'VIC'],
        ['postcode' => '3173', 'suburb' => 'Keysborough', 'state' => 'VIC'],
        ['postcode' => '3174', 'suburb' => 'Noble Park', 'state' => 'VIC'],
        ['postcode' => '3175', 'suburb' => 'Dandenong', 'state' => 'VIC'],
    ];
    
    $results = [];
    
    if (!empty($postcode)) {
        // Filter by postcode
        foreach ($vic_postcodes as $pc) {
            if ($pc['postcode'] == $postcode) {
                $results[] = $pc;
            }
        }
    } elseif (!empty($suburb)) {
        // Filter by suburb (case insensitive)
        $suburb_lower = strtolower($suburb);
        foreach ($vic_postcodes as $pc) {
            if (stripos(strtolower($pc['suburb']), $suburb_lower) !== false) {
                $results[] = $pc;
            }
        }
    }
    
    return $results;
}

// Try primary API first
$results = fetchFromPostcodeAPI($postcode, $suburb);

// If no results, try static fallback
if (empty($results)) {
    $results = getStaticVictorianPostcodes($postcode, $suburb);
}

// Prepare response
if (!empty($results)) {
    $response = [
        'success' => true,
        'results' => $results,
        'count' => count($results)
    ];
} else {
    $response = [
        'success' => false,
        'message' => 'No results found',
        'results' => []
    ];
}

// Log API usage for monitoring (optional)
if (file_exists('/opt/webstack/logs/')) {
    $log_entry = date('Y-m-d H:i:s') . " | " . 
                 ($_SERVER['REMOTE_ADDR'] ?? 'unknown') . " | " .
                 "postcode={$postcode} suburb={$suburb} | " .
                 "results=" . count($results) . "\n";
    @file_put_contents('/opt/webstack/logs/postcode_api.log', $log_entry, FILE_APPEND);
}

// Output JSON response
echo json_encode($response, JSON_PRETTY_PRINT);
?>