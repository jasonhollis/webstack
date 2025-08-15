#!/usr/bin/env python3
"""
Fetch Home Assistant integration icons from brands.home-assistant.io
Replaces the bash script with better error handling and logging
"""

import json
import os
import sys
import requests
from datetime import datetime
from pathlib import Path
import time

# Add the automation lib directory to the path for DatabaseLogger
sys.path.insert(0, '/opt/webstack/automation/lib')

try:
    from DatabaseLogger import DatabaseLogger
    db_logger = DatabaseLogger()
    use_db = True
except ImportError:
    print("Warning: DatabaseLogger not available, using file logging only")
    db_logger = None
    use_db = False

# Configuration
JSON_PATH = "/opt/webstack/html/data/ha_integrations.json"
OUTPUT_DIR = "/opt/webstack/html/images/icons"
LOG_DIR = "/opt/webstack/logs"
ICON_BASE = "https://brands.home-assistant.io"

# Brand slug mappings (domain -> actual brand slug on HA)
BRAND_MAP = {
    'amazon_alexa': 'alexa',
    'homekit_bridge': 'homekit',
    'homekit_controller': 'homekit',
    'porsche_connect': 'porscheconnect',
    'sony_bravia_tv': 'braviatv',
    'androidtv': 'androidtv',
    'lg_webos': 'webostv',
    'google_assistant': 'google_assistant',
    'apple_tv': 'appletv',
    'zigbee': 'zha',
    'yale': 'yale_smart_alarm',
    'wyze': 'wyze',
    'arlo': 'arlo',
    'chamberlain': 'chamberlain',
    'myq': 'myq',
    'lifx': 'lifx',
    'wiz': 'wiz',
    'govee': 'govee_ble',
    'lutron': 'lutron_caseta',
    'vizio': 'vizio',
    'yamaha': 'yamaha_musiccast',
    'airplay': 'airplay',
}

# Special cases that need custom handling
SPECIAL_CASES = {
    'zigbee2mqtt': 'https://www.zigbee2mqtt.io/logo.png',
}

# GitHub HACS integration search patterns
# These are common patterns for finding HACS integration icons on GitHub
GITHUB_ICON_PATTERNS = [
    # Pattern: (base_url, icon_paths_to_try)
    ('https://raw.githubusercontent.com/home-assistant/brands/master/custom_integrations/{domain}', ['icon.png', 'logo.png', 'icon@2x.png']),
    ('https://raw.githubusercontent.com/hacs-integrations/{domain}/main', ['icon.png', 'logo.png', 'custom_components/{domain}/icon.png']),
    ('https://raw.githubusercontent.com/custom-components/{domain}/master', ['icon.png', 'logo.png', 'custom_components/{domain}/icon.png']),
    # Specific known HACS repos
    ('https://raw.githubusercontent.com/SecKatie/ha-wyzeapi/main', ['images/wyze_logo_2021_black.png', 'custom_components/wyzeapi/icon.png']),
    ('https://raw.githubusercontent.com/libdyson-wg/ha-dyson/main', ['custom_components/dyson_cloud/icon.png', 'custom_components/dyson_local/icon.png']),
    ('https://raw.githubusercontent.com/shenxn/ha-dyson/main', ['custom_components/dyson_cloud/icon.png', 'custom_components/dyson_local/icon.png']),
    ('https://raw.githubusercontent.com/hjdhjd/homebridge-myq/main', ['homebridge-ui/public/myq.png', 'myq.png']),
    ('https://raw.githubusercontent.com/chamberlain-group/MyQ-Garage/main', ['icon.png', 'logo.png']),
]

# Domain-specific GitHub repos (for when domain name doesn't match repo name)
DOMAIN_TO_GITHUB = {
    'wyze': ['wyzeapi', 'ha-wyzeapi', 'wyze'],
    'myq': ['myq', 'pymyq', 'homebridge-myq'],
    'chamberlain': ['myq', 'chamberlain', 'MyQ-Garage'],
    'dyson': ['ha-dyson', 'dyson_cloud', 'dyson_local', 'libdyson'],
    'arlo': ['aarlo', 'arlo', 'pyarlo'],
    'airplay': ['airplay', 'apple_tv', 'pyatv'],
    'lg_webos': ['webostv', 'lgwebostv', 'lg-webos'],
}

def log_message(message, level='info'):
    """Log to both file and database"""
    timestamp = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
    
    # File logging
    log_file = Path(LOG_DIR) / f"ha_icon_fetch_{datetime.now().strftime('%Y%m%d-%H%M%S')}.log"
    with open(log_file, 'a') as f:
        f.write(f"[{timestamp}] {message}\n")
    
    # Console output
    print(message)
    
    # Database logging if available
    if use_db and level == 'error':
        try:
            db_logger.log_error(
                error_level='warning',
                error_source='fetch_ha_icons',
                error_message=message
            )
        except:
            pass  # Fail silently for DB logging

def download_icon(url, output_path, retries=3):
    """Download an icon with retry logic"""
    for attempt in range(retries):
        try:
            # Add headers for GitHub raw content
            headers = {
                'User-Agent': 'Mozilla/5.0 (compatible; KTP-Digital-Icon-Fetcher/1.0)',
                'Accept': 'image/png,image/svg+xml,image/*'
            }
            response = requests.get(url, timeout=10, headers=headers)
            if response.status_code == 200:
                # Verify we got actual image content
                content = response.content
                content_type = response.headers.get('content-type', '')
                
                # Check for actual image data (PNG magic bytes: 89 50 4E 47, JPEG: FF D8 FF)
                is_png = content[:4] == b'\x89PNG'
                is_jpeg = content[:3] == b'\xff\xd8\xff'
                is_svg = b'<svg' in content[:100] or b'<?xml' in content[:100]
                
                # Also check content type and size
                valid_content = 'image' in content_type or 'octet-stream' in content_type
                valid_size = len(content) > 500  # Images should be larger than 500 bytes
                
                if (is_png or is_jpeg or is_svg) and valid_size:
                    with open(output_path, 'wb') as f:
                        f.write(content)
                    return True
                else:
                    if len(content) < 100:
                        log_message(f"    File too small ({len(content)} bytes)", 'error')
                    else:
                        log_message(f"    Not an image file (type: {content_type})", 'error')
                    return False
            elif response.status_code == 404:
                return False  # Not found is expected for many icons
        except requests.RequestException as e:
            if attempt < retries - 1:
                time.sleep(2)  # Wait before retry
                continue
            else:
                log_message(f"Error downloading {url}: {e}", 'error')
                return False
    return False

def search_github_for_icon(domain):
    """Search GitHub for HACS integration icons"""
    log_message(f"  Searching GitHub for {domain} icon...")
    
    # Get possible repo names for this domain
    repo_names = DOMAIN_TO_GITHUB.get(domain, [domain])
    
    for base_url_template, icon_paths in GITHUB_ICON_PATTERNS:
        for repo_name in repo_names:
            # Skip if this pattern doesn't use domain substitution
            if '{domain}' in base_url_template:
                base_url = base_url_template.format(domain=repo_name)
            else:
                base_url = base_url_template
            
            for icon_path in icon_paths:
                # Replace {domain} in the icon path if present
                if '{domain}' in icon_path:
                    icon_path = icon_path.format(domain=repo_name)
                
                url = f"{base_url}/{icon_path}"
                output_path = Path(OUTPUT_DIR) / f"{domain}.png"
                
                log_message(f"    Trying GitHub: {url}")
                if download_icon(url, output_path, retries=1):  # Only 1 retry for GitHub
                    log_message(f"  ✓ Found on GitHub: {url}")
                    return True
                else:
                    # Clean up failed download
                    output_path.unlink(missing_ok=True)
    
    return False

def fetch_icons():
    """Main function to fetch all icons"""
    start_time = datetime.now()
    log_message(f"Starting HA icon fetch at {start_time}")
    
    # Start database operation logging
    operation_id = None
    if use_db:
        try:
            operation_id = db_logger.log_operation(
                operation_type='icon_fetch',
                operation_name='HA Icon Update',
                script_path='/opt/webstack/bin/fetch_ha_icons.py'
            )
        except:
            pass
    
    # Ensure directories exist
    Path(OUTPUT_DIR).mkdir(parents=True, exist_ok=True)
    Path(LOG_DIR).mkdir(parents=True, exist_ok=True)
    
    # Load integrations JSON
    if not Path(JSON_PATH).exists():
        log_message(f"ERROR: JSON file not found at {JSON_PATH}", 'error')
        return 1
    
    with open(JSON_PATH, 'r') as f:
        integrations = json.load(f)
    
    # Extract unique domains
    domains = sorted(set(item['domain'] for item in integrations))
    
    success_count = 0
    fail_count = 0
    skip_count = 0
    
    for domain in domains:
        log_message(f"=== {domain} ===")
        
        # Check if it's a special case
        if domain in SPECIAL_CASES:
            url = SPECIAL_CASES[domain]
            output_path = Path(OUTPUT_DIR) / f"{domain}.png"
            log_message(f"  Special case: fetching from {url}")
            if download_icon(url, output_path):
                log_message(f"  ✓ Downloaded special case icon")
                success_count += 1
            else:
                log_message(f"  ✗ Failed to download special case", 'error')
                fail_count += 1
            continue
        
        # Get the brand slug (with mapping if needed)
        slug = BRAND_MAP.get(domain, domain)
        log_message(f"  Using slug '{slug}'")
        
        # Check if icon already exists
        existing_svg = Path(OUTPUT_DIR) / f"{domain}.svg"
        existing_png = Path(OUTPUT_DIR) / f"{domain}.png"
        
        if existing_svg.exists() or existing_png.exists():
            log_message(f"  → Icon already exists, skipping")
            skip_count += 1
            continue
        
        # Try to download (SVG first, then PNG)
        fetched = False
        for ext in ['svg', 'png']:
            url = f"{ICON_BASE}/{slug}/logo.{ext}"
            output_path = Path(OUTPUT_DIR) / f"{domain}.{ext}"
            
            log_message(f"  Trying {url}...")
            if download_icon(url, output_path):
                log_message(f"  ✓ Downloaded {ext.upper()}")
                success_count += 1
                fetched = True
                break
            else:
                # Clean up failed download
                output_path.unlink(missing_ok=True)
        
        if not fetched:
            # Try alternative slugs for some problematic ones
            alternative_slugs = {
                'arlo': ['arlo', 'aarlo'],
                'wyze': ['wyze', 'wyze_custom'],
                'myq': ['myq', 'pymyq'],
                'chamberlain': ['chamberlain', 'myq'],
                'lg_webos': ['webostv', 'lgwebostv', 'lg_webos'],
                'airplay': ['airplay', 'apple_tv'],
                'vizio': ['vizio', 'viziotv'],
                'yamaha': ['yamaha', 'yamaha_musiccast'],
            }
            
            if domain in alternative_slugs:
                for alt_slug in alternative_slugs[domain]:
                    if alt_slug == slug:
                        continue  # Already tried this one
                    
                    log_message(f"  Trying alternative slug '{alt_slug}'")
                    for ext in ['svg', 'png']:
                        url = f"{ICON_BASE}/{alt_slug}/logo.{ext}"
                        output_path = Path(OUTPUT_DIR) / f"{domain}.{ext}"
                        
                        if download_icon(url, output_path):
                            log_message(f"  ✓ Downloaded {ext.upper()} with alt slug")
                            success_count += 1
                            fetched = True
                            break
                    
                    if fetched:
                        break
            
            # If still not found, try GitHub as a last resort
            if not fetched:
                if search_github_for_icon(domain):
                    log_message(f"  ✓ Found {domain} icon on GitHub")
                    success_count += 1
                    fetched = True
            
            if not fetched:
                log_message(f"  ✗ No icon found for {domain} (checked brands.home-assistant.io and GitHub)", 'error')
                fail_count += 1
    
    # Complete database operation logging
    end_time = datetime.now()
    duration = (end_time - start_time).total_seconds()
    
    summary = f"Fetch complete: {success_count} downloaded, {skip_count} skipped, {fail_count} failed in {duration:.1f}s"
    log_message(summary)
    
    if use_db and operation_id:
        try:
            db_logger.complete_operation(
                operation_id=operation_id,
                status='success' if fail_count == 0 else 'partial',
                exit_code=0,
                stdout=summary,
                stderr=f"{fail_count} icons failed to download" if fail_count > 0 else None
            )
        except:
            pass
    
    return 0 if fail_count == 0 else 1

if __name__ == "__main__":
    sys.exit(fetch_icons())