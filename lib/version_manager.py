#!/usr/bin/env python3
"""
Version Manager for KTP Webstack
Replaces update_version.sh with Python for better reliability and speed
Now with dual logging (database + file) for safe migration
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
import time

# Add DatabaseLogger support
sys.path.append('/opt/webstack/automation/lib')
try:
    from DatabaseLogger import DatabaseLogger
    db_logger = DatabaseLogger()
    DB_LOGGING = True
except Exception as e:
    print(f"⚠️ Database logging unavailable: {e}")
    db_logger = None
    DB_LOGGING = False

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
        self.stats = {}
        
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
        """Send failure notification via failure handler with DB logging"""
        # Log to database if available
        if DB_LOGGING and db_logger:
            try:
                db_logger.log_error(
                    error_level="error",
                    error_source="version_manager.py",
                    error_message=f"{context}: {error}"
                )
            except Exception as e:
                print(f"⚠️ DB error logging failed: {e}")
        
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
        
    def collect_git_stats(self):
        """Collect git statistics for the deployment"""
        try:
            # Get files changed in this commit
            result = self.run_command("git diff --stat HEAD~1 HEAD", check=False)
            if result and result.returncode == 0:
                lines = result.stdout.strip().split('\n')
                if lines and 'files changed' in lines[-1]:
                    # Parse: "X files changed, Y insertions(+), Z deletions(-)"
                    parts = lines[-1].split(',')
                    for part in parts:
                        if 'files changed' in part:
                            self.stats['files_changed'] = int(part.split()[0])
                        elif 'insertion' in part:
                            self.stats['insertions'] = int(part.split()[0])
                        elif 'deletion' in part:
                            self.stats['deletions'] = int(part.split()[0])
                            
            # Get total commits
            result = self.run_command("git rev-list --count HEAD", check=False)
            if result and result.returncode == 0:
                self.stats['total_commits'] = int(result.stdout.strip())
                
            # Get repo size
            result = self.run_command("du -sh /opt/webstack/.git | cut -f1", check=False)
            if result and result.returncode == 0:
                self.stats['repo_size'] = result.stdout.strip()
        except:
            pass
            
    def collect_snapshot_stats(self, snapshot_path):
        """Collect snapshot statistics"""
        try:
            if snapshot_path and snapshot_path.exists():
                size_bytes = snapshot_path.stat().st_size
                size_mb = size_bytes / (1024 * 1024)
                self.stats['snapshot_size'] = f"{size_mb:.1f}MB"
                self.stats['snapshot_name'] = snapshot_path.name
        except:
            pass
            
    def collect_database_stats(self):
        """Collect database statistics"""
        try:
            if DB_LOGGING and db_logger:
                # Query total version bumps
                result = self.run_command(
                    'echo "SELECT COUNT(*) FROM operation_logs WHERE operation_type=\'version_bump\';" | mariadb -u root ktp_digital -s',
                    check=False
                )
                if result and result.returncode == 0:
                    self.stats['total_versions'] = int(result.stdout.strip())
        except:
            pass
    
    def notify_success_async(self, version):
        """Send success notification with statistics"""
        try:
            # Build statistics message
            msg_parts = [f"Version {version} deployed successfully"]
            
            if self.stats.get('files_changed'):
                msg_parts.append(f"📝 {self.stats['files_changed']} files changed")
            if self.stats.get('insertions'):
                msg_parts.append(f"➕ {self.stats['insertions']} insertions")
            if self.stats.get('deletions'):
                msg_parts.append(f"➖ {self.stats['deletions']} deletions")
            if self.stats.get('snapshot_size'):
                msg_parts.append(f"💾 Snapshot: {self.stats['snapshot_size']}")
            if self.stats.get('duration'):
                msg_parts.append(f"⏱️ Duration: {self.stats['duration']:.1f}s")
            if self.stats.get('total_commits'):
                msg_parts.append(f"📊 Total commits: {self.stats['total_commits']}")
            if self.stats.get('repo_size'):
                msg_parts.append(f"📦 Repo size: {self.stats['repo_size']}")
                
            message = "\n".join(msg_parts)
            
            # Prefer Python notifier
            notify_py = Path("/opt/webstack/bin/notify_pushover.py")
            if notify_py.exists():
                subprocess.run(
                    ["python3", str(notify_py), "Webstack Update", message],
                    capture_output=True,
                    timeout=5,
                    check=False
                )
            elif self.notify_script.exists():
                # Fall back to bash version
                subprocess.run(
                    [str(self.notify_script), "Webstack Update", message],
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
        # Define patterns for screenshot files (not Adobe Stock or other assets)
        screenshot_patterns = [
            "screenshot-*.png",
            "screenshot-*.jpg",
            "screenshot-*.jpeg", 
            "screenshot-*.gif",
            "screenshot-*.pdf",
            "screenshot-*.mov",
            "screenshot-*.mp4"
        ]
        
        # Collect all screenshot files
        screenshot_files = []
        for pattern in screenshot_patterns:
            screenshot_files.extend(list(self.screenshots_dir.glob(pattern)))
        
        if screenshot_files:
            print(f"📸 Archiving {len(screenshot_files)} screenshots for version {version}...")
            timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")
            archive_path = self.snapshots_dir / f"screenshots_{version}_{timestamp}.zip"
            
            try:
                with zipfile.ZipFile(archive_path, 'w', zipfile.ZIP_DEFLATED) as zf:
                    for file in screenshot_files:
                        zf.write(file, file.name)
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
            
        # Remove screenshots after archiving (same patterns as archive)
        screenshot_patterns = [
            "screenshot-*.png",
            "screenshot-*.jpg",
            "screenshot-*.jpeg",
            "screenshot-*.gif", 
            "screenshot-*.pdf",
            "screenshot-*.mov",
            "screenshot-*.mp4"
        ]
        
        for pattern in screenshot_patterns:
            for file in self.screenshots_dir.glob(pattern):
                try:
                    file.unlink()
                except:
                    pass
                
    def create_snapshot(self, version):
        """Create snapshot of the current version and return path"""
        timestamp = datetime.now().strftime("%Y-%m-%d-%H%M%S")
        snapshot_path = self.snapshots_dir / f"webstack-{version}-{timestamp}.zip"
        
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
        
        return snapshot_path
                
    def git_operations(self, new_version):
        """Handle all git operations"""
        # Add all changes
        self.run_command("git add -A")
        
        # Commit
        commit_msg = f"⬆️ Version bump: {new_version}"
        self.run_command(f'git commit -m "{commit_msg}"')
        
        # Push to origin/master (30s timeout for normal pushes)
        print("📤 Pushing to remote repository...")
        result = self.run_command("git push origin master 2>&1", check=False, timeout=30)
        if result is None:
            print("⚠️ Git push timed out. Changes saved locally. Push manually later.")
        elif result and result.returncode != 0:
            print(f"⚠️ Git push failed: {result.stdout if result.stdout else 'Unknown error'}")
        else:
            print("✅ Pushed to origin/master")
            
        # Create annotated tag
        self.run_command(f'git tag -a {new_version} -m "Version {new_version}"')
        
        # Push tag
        result = self.run_command(f"git push origin {new_version} 2>&1", check=False, timeout=30)
        if result and result.returncode == 0:
            print(f"✅ Tag {new_version} pushed")
        else:
            print(f"⚠️ Tag push skipped. Tag {new_version} created locally.")
            
    def reload_services(self):
        """Reload PHP-FPM to flush OPcache"""
        self.run_command("systemctl reload php8.2-fpm", check=False, timeout=5)
        
    def create_version_files(self, version):
        """Create iteration and objectives files for new version with initial content"""
        iteration_file = self.objectives_dir / f"{version}_iteration_log.md"
        objective_file = self.objectives_dir / f"{version}_objectives.md"
        
        # Create iteration log with header
        if not iteration_file.exists():
            try:
                iteration_content = f"# {version} Iteration Log\n*Session: {datetime.now().strftime('%A, %B %d, %Y')}*\n\n## Session Overview\n\n"
                iteration_file.write_text(iteration_content)
                os.chown(iteration_file, 0, 33)  # root:www-data
                iteration_file.chmod(0o664)
                print(f"✅ Created: {iteration_file.name}")
            except Exception as e:
                print(f"⚠️ Failed to create {iteration_file.name}: {e}")
        
        # Create objectives file with header
        if not objective_file.exists():
            try:
                objectives_content = f"# {version} Objectives\n\n## Primary Goals\n\n## Tasks\n\n## Notes\n\n"
                objective_file.write_text(objectives_content)
                os.chown(objective_file, 0, 33)  # root:www-data
                objective_file.chmod(0o664)
                print(f"✅ Created: {objective_file.name}")
            except Exception as e:
                print(f"⚠️ Failed to create {objective_file.name}: {e}")
            
    def log_version_update(self, version):
        """Log the version update"""
        timestamp = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
        with open(self.log_file, 'a') as f:
            f.write(f"[{timestamp}] Version updated to {version}\n")
            
    def update_version(self, new_version=None):
        """Main version update process with dual logging and statistics"""
        # Track start time
        start_time = time.time()
        
        # Get current version
        old_version = self.get_current_version()
        
        # Get new version from argument or prompt
        if not new_version:
            new_version = input("🔢 Enter new version (e.g. v1.4.9-dev): ").strip()
            
        if not new_version:
            self.notify_failure("update_version", "No version entered")
            sys.exit(1)
            
        print(f"📌 Updating from {old_version} to {new_version}")
        
        # Start database logging operation
        op_id = None
        if DB_LOGGING and db_logger:
            try:
                op_id = db_logger.log_operation(
                    operation_type='version_bump',
                    operation_name=f'{old_version} → {new_version}',
                    script_path='bin/update_version.py'
                )
            except Exception as e:
                print(f"⚠️ DB logging failed to start: {e}")
        
        # Archive screenshots before cleaning
        self.archive_screenshots(old_version)
        
        # Cleanup
        self.cleanup_files()
        
        # Create snapshot of old version
        snapshot_path = self.create_snapshot(old_version)
        self.collect_snapshot_stats(snapshot_path)
        
        # Update VERSION file
        self.version_file.write_text(new_version)
        print(f"✏️ Updated VERSION file to {new_version}")
        
        # Git operations
        self.git_operations(new_version)
        
        # Collect statistics after git operations
        self.collect_git_stats()
        self.collect_database_stats()
        
        # Reload services
        self.reload_services()
        
        # Create version files
        self.create_version_files(new_version)
        
        # Log the update
        self.log_version_update(new_version)
        
        # Calculate duration
        self.stats['duration'] = time.time() - start_time
        
        # Display statistics
        print("\n📊 Deployment Statistics:")
        if self.stats.get('files_changed'):
            print(f"   📝 Files changed: {self.stats['files_changed']}")
        if self.stats.get('insertions'):
            print(f"   ➕ Insertions: {self.stats['insertions']}")
        if self.stats.get('deletions'):
            print(f"   ➖ Deletions: {self.stats['deletions']}")
        if self.stats.get('snapshot_size'):
            print(f"   💾 Snapshot size: {self.stats['snapshot_size']}")
        if self.stats.get('total_commits'):
            print(f"   📈 Total commits: {self.stats['total_commits']}")
        if self.stats.get('repo_size'):
            print(f"   📦 Repository size: {self.stats['repo_size']}")
        if self.stats.get('total_versions'):
            print(f"   🏷️ Total versions: {self.stats['total_versions']}")
        print(f"   ⏱️ Duration: {self.stats['duration']:.1f} seconds")
        
        print(f"\n✅ Version {new_version} deployed, committed, tagged, and snapshotted")
        
        # Complete database logging operation
        if DB_LOGGING and db_logger and op_id:
            try:
                db_logger.complete_operation(
                    operation_id=op_id,
                    status='success',
                    exit_code=0,
                    stdout=f"Successfully updated from {old_version} to {new_version}"
                )
            except Exception as e:
                print(f"⚠️ DB logging failed to complete: {e}")
        
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