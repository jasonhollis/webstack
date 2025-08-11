#!/usr/bin/env python3
"""
Remove dark mode classes from admin pages
Makes the admin interface cleaner and more readable
"""

import re
from pathlib import Path

def remove_dark_classes(content):
    """Remove all dark: prefixed Tailwind classes"""
    # Pattern to match dark: classes (handles multi-class attributes)
    # This will remove dark:classname patterns while preserving other classes
    
    # Remove dark: classes from class attributes
    content = re.sub(r'\sdark:[a-zA-Z0-9\-]+', '', content)
    
    # Remove any resulting double spaces
    content = re.sub(r'\s+', ' ', content)
    
    # Clean up empty class attributes
    content = re.sub(r'class="\s*"', '', content)
    content = re.sub(r"class='\s*'", '', content)
    
    # Also remove dark mode specific CSS rules
    content = re.sub(r'@media\s*\(prefers-color-scheme:\s*dark\)\s*\{[^}]*\}', '', content, flags=re.DOTALL)
    
    return content

def process_admin_files():
    """Process all PHP files in admin directory"""
    admin_dir = Path("/opt/webstack/html/admin")
    
    files_processed = 0
    
    for php_file in admin_dir.glob("*.php"):
        # Skip test files
        if 'test' in php_file.name.lower():
            continue
            
        try:
            content = php_file.read_text()
            original_len = len(content)
            
            # Check if file has dark mode classes
            if 'dark:' in content:
                # Remove dark mode classes
                new_content = remove_dark_classes(content)
                
                # Write back if changed
                if new_content != content:
                    php_file.write_text(new_content)
                    removed = original_len - len(new_content)
                    print(f"✅ {php_file.name}: Removed {removed} characters of dark mode code")
                    files_processed += 1
                    
        except Exception as e:
            print(f"❌ Error processing {php_file.name}: {e}")
    
    print(f"\n🎯 Processed {files_processed} files")
    print("💡 Admin interface is now light mode only - cleaner and more readable!")

if __name__ == "__main__":
    process_admin_files()