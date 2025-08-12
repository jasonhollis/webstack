#!/usr/bin/env python3
"""
Failure Handler for KTP Webstack
Replaces failure.sh with Python for better reliability and database integration
Now with dual logging (database + file) for safe migration
"""

import os
import sys
import json
import requests
from datetime import datetime
from pathlib import Path
from typing import Optional
import logging

# Add DatabaseLogger support
sys.path.append('/opt/webstack/automation/lib')
try:
    from DatabaseLogger import DatabaseLogger
    db_logger = DatabaseLogger()
    DB_LOGGING = True
except Exception as e:
    print(f"⚠️ Database logging unavailable: {e}", file=sys.stderr)
    db_logger = None
    DB_LOGGING = False

class FailureHandler:
    def __init__(self):
        self.log_file = Path("/opt/webstack/logs/failures.log")
        self.pushover_user = "uh1ozrrcj8y5jktg5euc6yz6zpdcqh"
        self.pushover_token = "aqfyb8hsfb6txs6pd4qwchjwd3iccb"
        self.pushover_sound = "siren"
        self.pushover_url = "https://api.pushover.net/1/messages.json"
        
        # Ensure log directory exists
        self.log_file.parent.mkdir(parents=True, exist_ok=True)
        
        # Setup logging
        logging.basicConfig(
            level=logging.INFO,
            format='%(asctime)s - %(levelname)s - %(message)s'
        )
        self.logger = logging.getLogger(__name__)
        
    def log_failure(self, context: str, details: str) -> None:
        """Log failure to both database and file (dual logging)"""
        timestamp = datetime.now().strftime('%Y-%m-%d %H:%M:%S %Z')
        log_entry = f"[{timestamp}][{context}] {details}\n"
        
        # Database logging (if available)
        if DB_LOGGING and db_logger:
            try:
                db_logger.log_error(
                    error_level='critical',  # Failures are always critical
                    error_source=context,
                    error_message=details
                )
                self.logger.debug("Failure logged to database")
            except Exception as e:
                self.logger.warning(f"Database logging failed: {e}")
        
        # File logging (always, as fallback)
        try:
            with open(self.log_file, 'a') as f:
                f.write(log_entry)
            self.logger.info(f"Logged failure: {context} - {details}")
        except Exception as e:
            self.logger.error(f"Failed to write to log file: {e}")
            # Still continue to try Pushover notification
            
    def send_pushover_alert(self, context: str, details: str) -> bool:
        """Send Pushover alert for failure"""
        if not (self.pushover_user and self.pushover_token):
            self.logger.warning("Pushover credentials not configured")
            return False
            
        payload = {
            'token': self.pushover_token,
            'user': self.pushover_user,
            'title': f'Webstack FAILURE: {context}',
            'message': details,
            'sound': self.pushover_sound
        }
        
        try:
            response = requests.post(
                self.pushover_url,
                data=payload,
                timeout=(5, 10)  # 5s connect, 10s read timeout
            )
            
            if response.status_code == 200:
                result = response.json()
                if result.get('status') == 1:
                    self.logger.info("Pushover alert sent successfully")
                    return True
                else:
                    self.logger.warning(f"Pushover API error: {result}")
                    return False
            else:
                self.logger.warning(f"Pushover HTTP error: {response.status_code}")
                return False
                
        except requests.exceptions.Timeout:
            self.logger.warning("Pushover request timed out")
            return False
        except requests.exceptions.RequestException as e:
            self.logger.warning(f"Pushover request failed: {e}")
            return False
        except Exception as e:
            self.logger.error(f"Unexpected error sending Pushover: {e}")
            return False
            
    def handle_failure(self, context: str, details: str) -> None:
        """Main method to handle a failure event"""
        # Always log to file
        self.log_failure(context, details)
        
        # Try to send Pushover alert (non-blocking)
        self.send_pushover_alert(context, details)
        
        # Print to stderr for immediate visibility
        print(f"❌ FAILURE [{context}]: {details}", file=sys.stderr)
        
    def log_to_database(self, context: str, details: str) -> bool:
        """
        Future: Log failure to database
        Ready for implementation when database logging is added
        """
        # TODO: Implement database logging
        # This will be added in a future version
        # Structure ready for:
        # - Connection to MySQL/MariaDB
        # - Insert into failures table
        # - Structured data storage
        return False

def main():
    """Main entry point - compatible with failure.sh usage"""
    if len(sys.argv) < 3:
        print("Usage: failure_handler.py 'Context/Script' 'Message or details'", 
              file=sys.stderr)
        sys.exit(1)
        
    context = sys.argv[1]
    details = sys.argv[2]
    
    handler = FailureHandler()
    handler.handle_failure(context, details)
    
    # Exit with error code to maintain compatibility
    sys.exit(1)

if __name__ == "__main__":
    main()