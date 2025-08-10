#!/usr/bin/env python3
"""
Snapshot Manager for KTP Webstack
Replaces snapshot_webstack.sh with Python for better reliability
"""

import os
import sys
import subprocess
import zipfile
from datetime import datetime
from pathlib import Path
import fnmatch

class SnapshotManager:
    def __init__(self):
        self.webstack_dir = Path("/opt/webstack")
        self.snapshots_dir = self.webstack_dir / "snapshots"
        self.version_file = Path("/opt/webstack/html/VERSION")
        self.deploy_log = Path("/opt/webstack/logs/deploy.log")
        
        # Ensure snapshots directory exists
        self.snapshots_dir.mkdir(parents=True, exist_ok=True)
        
        # Directories to include in snapshot
        self.include_dirs = [
            "html",
            "bin", 
            "logs",
            "objectives",
            "assets",
        ]
        
        # External configs to include
        self.external_files = [
            "/etc/nginx/nginx.conf",
            "/etc/nginx/sites-available",
        ]
        
        # Patterns to exclude
        self.exclude_patterns = [
            "snapshots/*",
            "html/snapshots/*", 
            "logs/*.gz",
            "logs/*old*",
            "logs/*.zip",
            "*.mp4",
            "*.mov",
            "*.webm",
            "*.psd",
            "objectives/images/*",
            "screenshots/*"
        ]
        
    def get_version(self, version_override=None):
        """Get version from argument or VERSION file"""
        if version_override:
            return version_override
            
        if self.version_file.exists():
            return self.version_file.read_text().strip()
        
        return "unknown"
        
    def should_exclude(self, file_path):
        """Check if a file should be excluded based on patterns"""
        # Convert to relative path from webstack dir
        try:
            rel_path = Path(file_path).relative_to(self.webstack_dir)
        except ValueError:
            # Not in webstack dir, don't exclude
            return False
            
        rel_str = str(rel_path)
        
        for pattern in self.exclude_patterns:
            if fnmatch.fnmatch(rel_str, pattern):
                return True
                
        return False
        
    def create_snapshot(self, version=None):
        """Create a snapshot of the webstack"""
        version = self.get_version(version)
        timestamp = datetime.now().strftime("%Y-%m-%d-%H%M%S")
        snapshot_name = f"webstack-{version}-{timestamp}.zip"
        snapshot_path = self.snapshots_dir / snapshot_name
        
        print(f"[{datetime.now()}] 📦 Starting snapshot for version {version}...", file=sys.stderr)
        
        try:
            with zipfile.ZipFile(snapshot_path, 'w', zipfile.ZIP_DEFLATED) as zf:
                # Add webstack directories
                for dir_name in self.include_dirs:
                    dir_path = self.webstack_dir / dir_name
                    if dir_path.exists():
                        self.add_directory_to_zip(zf, dir_path)
                
                # VERSION file is already included via html/ directory
                # No need to add it separately
                
                # Add external config files
                for external_file in self.external_files:
                    external_path = Path(external_file)
                    if external_path.exists():
                        if external_path.is_file():
                            # Add single file
                            arcname = external_path.relative_to("/")
                            zf.write(external_path, arcname)
                        elif external_path.is_dir():
                            # Add directory recursively
                            self.add_directory_to_zip(zf, external_path, 
                                                     base_path=Path("/"))
            
            print(f"[{datetime.now()}] 📦 Snapshot completed (excluded videos and screenshots)", 
                  file=sys.stderr)
            
            # Log to deploy.log
            log_message = f"[{datetime.now()}] 📦 Snapshot created: {snapshot_name}\n"
            with open(self.deploy_log, 'a') as f:
                f.write(log_message)
            
            print(f"[{datetime.now()}] 📦 Snapshot created: {snapshot_name}")
            
            return snapshot_path
            
        except Exception as e:
            print(f"❌ Snapshot failed: {e}", file=sys.stderr)
            sys.exit(1)
            
    def add_directory_to_zip(self, zf, dir_path, base_path=None):
        """Recursively add directory to zip, respecting exclusions"""
        if base_path is None:
            base_path = self.webstack_dir
            
        for root, dirs, files in os.walk(dir_path):
            root_path = Path(root)
            
            # Skip excluded directories
            dirs[:] = [d for d in dirs if not self.should_exclude(root_path / d)]
            
            for file in files:
                file_path = root_path / file
                
                # Skip excluded files
                if self.should_exclude(file_path):
                    continue
                    
                # Skip if file doesn't exist (broken symlink, etc)
                if not file_path.exists():
                    continue
                    
                # Calculate archive name (relative path in zip)
                try:
                    arcname = file_path.relative_to(base_path)
                except ValueError:
                    # If can't get relative path, use absolute
                    arcname = file_path
                    
                try:
                    zf.write(file_path, arcname)
                except Exception as e:
                    print(f"⚠️ Skipped {file_path}: {e}", file=sys.stderr)
                    
    def clean_logs(self):
        """Clean log files (currently disabled like in shell script)"""
        # This is commented out in the original script too
        # find /opt/webstack/logs -type f ! -name 'deploy.log' -exec truncate -s 0 {} \;
        pass

def main():
    """Main entry point"""
    version = sys.argv[1] if len(sys.argv) > 1 else None
    
    manager = SnapshotManager()
    snapshot_path = manager.create_snapshot(version)
    
    return 0

if __name__ == "__main__":
    sys.exit(main())