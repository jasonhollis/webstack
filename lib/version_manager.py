#!/usr/bin/env python3
"""
Version Manager for KTP Webstack
Replaces update_version.sh with Python for better reliability and speed
"""

import os
import sys
import subprocess
import shutil
import glob
from datetime import datetime
from pathlib import Path
import threading
import zipfile

class VersionManager:
    def __init__(self):
        self.repo_dir = Path("/opt/webstack/html")
        self.objectives_dir = Path("/opt/webstack/objectives")
        self.snapshots_dir = Path("/opt/webstack/snapshots")
        self.screenshots_dir = Path("/opt/webstack/screenshots")
        self.version_file = self.repo_dir / "VERSION"
        self.log_file = Path("/opt/webstack/logs/deploy_webhook.log")
        self.snapshot_script = Path("/opt/webstack/bin/snapshot_webstack.sh")
        self.notify_script = Path("/opt/webstack/bin/notify_pushover.sh")
        
    def run_command(self, cmd, check=True, capture_output=True, timeout=30):
        """Run a shell command with proper error handling"""
        try:
            # Ensure we inherit the full environment including SSH agent
            env = os.environ.copy()
            result = subprocess.run(
                cmd, 
                shell=True if isinstance(cmd, str) else False,
                check=check,
                capture_output=capture_output,
                text=True,
                timeout=timeout,
                cwd=str(self.repo_dir),
                env=env
            )
            return result
        except subprocess.CalledProcessError as e:
            if check:
                self.notify_failure(f"Command failed: {cmd}", str(e))
                sys.exit(1)
            return e
        except subprocess.TimeoutExpired:
            print(f"⚠️ Command timed out: {cmd}")
            return None
            
    def notify_failure(self, context, error):
        """Send failure notification via failure handler"""
        # Prefer Python version, fall back to bash
        failure_py = "/opt/webstack/bin/failure.py"
        failure_sh = "/opt/webstack/bin/failure.sh"
        
        if os.path.exists(failure_py):
            subprocess.run(["python3", failure_py, "version_manager.py", f"{context}: {error}"], 
                         capture_output=True, timeout=5)
        elif os.path.exists(failure_sh):
            subprocess.run([failure_sh, "version_manager.py", f"{context}: {error}"], 
                         capture_output=True, timeout=5)
        print(f"❌ {context}: {error}")
        
    def notify_success_async(self, version):
        """Send success notification - prefer Python version"""
        try:
            # Prefer Python notifier
            notify_py = Path("/opt/webstack/bin/notify_pushover.py")
            if notify_py.exists():
                subprocess.run(
                    ["python3", str(notify_py), "Webstack Update", 
                     f"Version {version} deployed successfully"],
                    capture_output=True,
                    timeout=5,
                    check=False
                )
            elif self.notify_script.exists():
                # Fall back to bash version
                subprocess.run(
                    [str(self.notify_script), "Webstack Update", 
                     f"Version {version} deployed successfully"],
                    capture_output=True,
                    timeout=5,
                    check=False
                )
        except:
            pass  # Silent fail for notifications
        
    def get_current_version(self):
        """Read current version from VERSION file"""
        if self.version_file.exists():
            return self.version_file.read_text().strip()
        return "unknown"
        
    def archive_screenshots(self, version):
        """Archive screenshots for the current version"""
        png_files = list(self.screenshots_dir.glob("*.png"))
        if png_files:
            print(f"📸 Archiving {len(png_files)} screenshots for version {version}...")
            timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")
            archive_path = self.snapshots_dir / f"screenshots_{version}_{timestamp}.zip"
            
            try:
                with zipfile.ZipFile(archive_path, 'w', zipfile.ZIP_DEFLATED) as zf:
                    for png in png_files:
                        zf.write(png, png.name)
                print(f"📸 Screenshots archived to: {archive_path.name}")
            except Exception as e:
                print(f"⚠️ Screenshot archive failed: {e}")
                
    def cleanup_files(self):
        """Clean temporary files and screenshots"""
        print("🧹 Cleaning temporary files and screenshots...")
        
        # Remove temporary files
        for pattern in ["/opt/webstack/snapshots/zi*"]:
            for file in glob.glob(pattern):
                try:
                    os.remove(file)
                except:
                    pass
                    
        # Remove old objective images (30+ days)
        try:
            self.run_command(
                "find /opt/webstack/objectives/images -name '*.png' -mtime +30 -delete 2>/dev/null",
                check=False
            )
        except:
            pass
            
        # Remove screenshots after archiving
        for png in self.screenshots_dir.glob("*.png"):
            try:
                png.unlink()
            except:
                pass
                
    def create_snapshot(self, version):
        """Create snapshot of the current version"""
        # Use Python snapshot manager if available, fall back to bash
        snapshot_py = Path("/opt/webstack/bin/snapshot_webstack.py")
        if snapshot_py.exists():
            print(f"📦 Creating snapshot for version {version}...")
            result = self.run_command(
                f"python3 {snapshot_py} {version}",
                check=False,
                timeout=60
            )
            if result and result.returncode != 0:
                self.notify_failure("snapshot_manager.py", f"Failed for version {version}")
                sys.exit(1)
        elif self.snapshot_script.exists():
            print(f"📦 Creating snapshot for version {version}...")
            result = self.run_command(
                f"bash {self.snapshot_script} {version}",
                check=False,
                timeout=60
            )
            if result and result.returncode != 0:
                self.notify_failure("snapshot_webstack.sh", f"Failed for version {version}")
                sys.exit(1)
                
    def git_operations(self, new_version):
        """Handle all git operations"""
        # Add all changes
        self.run_command("git add -A")
        
        # Commit
        commit_msg = f"⬆️ Version bump: {new_version}"
        self.run_command(f'git commit -m "{commit_msg}"')
        
        # Push to origin/master (quick timeout to avoid hanging)
        print("📤 Pushing to remote repository...")
        result = self.run_command("git push origin master 2>&1", check=False, timeout=5)
        if result is None:
            print("⚠️ Git push timed out. Changes saved locally. Push manually later.")
        elif result and result.returncode != 0:
            print(f"⚠️ Git push failed: {result.stdout if result.stdout else 'Unknown error'}")
        else:
            print("✅ Pushed to origin/master")
            
        # Create annotated tag
        self.run_command(f'git tag -a {new_version} -m "Version {new_version}"')
        
        # Push tag
        result = self.run_command(f"git push origin {new_version} 2>&1", check=False, timeout=5)
        if result and result.returncode == 0:
            print(f"✅ Tag {new_version} pushed")
        else:
            print(f"⚠️ Tag push skipped. Tag {new_version} created locally.")
            
    def reload_services(self):
        """Reload PHP-FPM to flush OPcache"""
        self.run_command("systemctl reload php8.2-fpm", check=False, timeout=5)
        
    def create_version_files(self, version):
        """Create iteration and objectives files for new version"""
        iteration_file = self.objectives_dir / f"{version}_iteration_log.md"
        objective_file = self.objectives_dir / f"{version}_objectives.md"
        
        for file in [iteration_file, objective_file]:
            try:
                file.touch(exist_ok=True)
                os.chown(file, 0, 33)  # root:www-data (gid 33 is www-data)
                file.chmod(0o664)
                print(f"✅ Created: {file.name}")
            except Exception as e:
                print(f"⚠️ Failed to create {file.name}: {e}")
            
    def log_version_update(self, version):
        """Log the version update"""
        timestamp = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
        with open(self.log_file, 'a') as f:
            f.write(f"[{timestamp}] Version updated to {version}\n")
            
    def update_version(self, new_version=None):
        """Main version update process"""
        # Get current version
        old_version = self.get_current_version()
        
        # Get new version from argument or prompt
        if not new_version:
            new_version = input("🔢 Enter new version (e.g. v1.4.9-dev): ").strip()
            
        if not new_version:
            self.notify_failure("update_version", "No version entered")
            sys.exit(1)
            
        print(f"📌 Updating from {old_version} to {new_version}")
        
        # Archive screenshots before cleaning
        self.archive_screenshots(old_version)
        
        # Cleanup
        self.cleanup_files()
        
        # Create snapshot of old version
        self.create_snapshot(old_version)
        
        # Update VERSION file
        self.version_file.write_text(new_version)
        print(f"✏️ Updated VERSION file to {new_version}")
        
        # Git operations
        self.git_operations(new_version)
        
        # Reload services
        self.reload_services()
        
        # Create version files
        self.create_version_files(new_version)
        
        # Log the update
        self.log_version_update(new_version)
        
        print(f"✅ Version {new_version} deployed, committed, tagged, and snapshotted")
        
        # Send notification asynchronously (won't block)
        self.notify_success_async(new_version)
        
        return 0

def main():
    """Main entry point"""
    version = sys.argv[1] if len(sys.argv) > 1 else None
    
    manager = VersionManager()
    return manager.update_version(version)

if __name__ == "__main__":
    sys.exit(main())