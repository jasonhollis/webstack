#!/usr/bin/env python3
"""
Notifier for KTP Webstack
Replaces notify_pushover.sh with Python for better reliability and extensibility
"""

import os
import sys
import json
import requests
from datetime import datetime
from pathlib import Path
from typing import Optional, Dict, Any
import logging
from enum import Enum

# Add DatabaseLogger support for notification tracking
sys.path.append('/opt/webstack/automation/lib')
try:
    from DatabaseLogger import DatabaseLogger
    db_logger = DatabaseLogger()
    DB_LOGGING = True
except Exception as e:
    db_logger = None
    DB_LOGGING = False

class NotificationPriority(Enum):
    """Pushover priority levels"""
    LOWEST = -2
    LOW = -1
    NORMAL = 0
    HIGH = 1
    EMERGENCY = 2

class NotificationSound(Enum):
    """Pushover notification sounds"""
    PUSHOVER = "pushover"
    BIKE = "bike"
    BUGLE = "bugle"
    CASHREGISTER = "cashregister"
    CLASSICAL = "classical"
    COSMIC = "cosmic"
    FALLING = "falling"
    GAMELAN = "gamelan"
    INCOMING = "incoming"
    INTERMISSION = "intermission"
    MAGIC = "magic"
    MECHANICAL = "mechanical"
    PIANOBAR = "pianobar"
    SIREN = "siren"
    SPACEALARM = "spacealarm"
    TUGBOAT = "tugboat"
    ALIEN = "alien"
    CLIMB = "climb"
    PERSISTENT = "persistent"
    ECHO = "echo"
    UPDOWN = "updown"
    NONE = "none"

class Notifier:
    def __init__(self):
        self.pushover_user = "uh1ozrrcj8y5jktg5euc6yz6zpdcqh"
        self.pushover_token = "aqfyb8hsfb6txs6pd4qwchjwd3iccb"
        self.pushover_url = "https://api.pushover.net/1/messages.json"
        
        # Setup logging
        logging.basicConfig(
            level=logging.INFO,
            format='%(asctime)s - %(name)s - %(levelname)s - %(message)s'
        )
        self.logger = logging.getLogger(__name__)
        
    def send_pushover(
        self,
        title: str = "Webstack Notification",
        message: str = "No details provided.",
        url: Optional[str] = None,
        url_title: Optional[str] = "View Details",
        priority: NotificationPriority = NotificationPriority.NORMAL,
        sound: Optional[str] = None,
        device: Optional[str] = None,
        html: bool = False
    ) -> bool:
        """
        Send a Pushover notification with full feature support
        
        Args:
            title: Notification title
            message: Notification message
            url: Optional URL to include
            url_title: Title for the URL button
            priority: Notification priority level
            sound: Notification sound (optional)
            device: Specific device to send to (optional)
            html: Enable HTML formatting in message
            
        Returns:
            True if successful, False otherwise
        """
        if not (self.pushover_user and self.pushover_token):
            self.logger.error("Pushover credentials not configured")
            return False
            
        # Build payload
        payload = {
            'token': self.pushover_token,
            'user': self.pushover_user,
            'title': title,
            'message': message,
            'priority': priority.value if isinstance(priority, NotificationPriority) else priority
        }
        
        # Add optional parameters
        if url:
            payload['url'] = url
            payload['url_title'] = url_title
        if sound:
            payload['sound'] = sound
        if device:
            payload['device'] = device
        if html:
            payload['html'] = 1
            
        try:
            # Send request with proper timeouts
            response = requests.post(
                self.pushover_url,
                data=payload,
                timeout=(5, 10)  # 5s connect, 10s read
            )
            
            # Check response
            if response.status_code == 200:
                result = response.json()
                if result.get('status') == 1:
                    self.logger.info(f"Pushover notification sent: {title}")
                    # Log successful notification to database
                    if DB_LOGGING and db_logger:
                        try:
                            db_logger.log_operation(
                                operation_type='api_call',
                                operation_name=f'Pushover: {title}',
                                script_path='lib/notifier.py'
                            )
                        except Exception as e:
                            self.logger.debug(f"DB logging failed: {e}")
                    return True
                else:
                    errors = result.get('errors', [])
                    self.logger.error(f"Pushover API errors: {errors}")
                    # Log failed notification to database
                    if DB_LOGGING and db_logger:
                        try:
                            db_logger.log_error(
                                error_level='warning',
                                error_source='pushover_api',
                                error_message=f"Notification failed: {errors}"
                            )
                        except Exception as e:
                            self.logger.debug(f"DB error logging failed: {e}")
                    return False
            else:
                self.logger.error(f"Pushover HTTP error: {response.status_code}")
                self.logger.debug(f"Response: {response.text}")
                return False
                
        except requests.exceptions.Timeout:
            self.logger.warning("Pushover request timed out")
            if DB_LOGGING and db_logger:
                try:
                    db_logger.log_error(
                        error_level='warning',
                        error_source='pushover_timeout',
                        error_message=f"Notification timeout: {title}"
                    )
                except:
                    pass
            return False
        except requests.exceptions.ConnectionError:
            self.logger.error("Could not connect to Pushover API")
            if DB_LOGGING and db_logger:
                try:
                    db_logger.log_error(
                        error_level='error',
                        error_source='pushover_connection',
                        error_message="Could not connect to Pushover API"
                    )
                except:
                    pass
            return False
        except requests.exceptions.RequestException as e:
            self.logger.error(f"Pushover request failed: {e}")
            if DB_LOGGING and db_logger:
                try:
                    db_logger.log_error(
                        error_level='error',
                        error_source='pushover_request',
                        error_message=f"Request failed: {e}"
                    )
                except:
                    pass
            return False
        except json.JSONDecodeError as e:
            self.logger.error(f"Invalid JSON response from Pushover: {e}")
            return False
        except Exception as e:
            self.logger.error(f"Unexpected error sending Pushover: {e}")
            return False
            
    def send_success(self, context: str, details: str) -> bool:
        """Send a success notification (normal priority, default sound)"""
        return self.send_pushover(
            title=f"✅ {context}",
            message=details,
            priority=NotificationPriority.NORMAL
        )
        
    def send_failure(self, context: str, details: str) -> bool:
        """Send a failure notification (high priority, siren sound)"""
        return self.send_pushover(
            title=f"❌ FAILURE: {context}",
            message=details,
            priority=NotificationPriority.HIGH,
            sound=NotificationSound.SIREN.value
        )
        
    def send_warning(self, context: str, details: str) -> bool:
        """Send a warning notification (normal priority, magic sound)"""
        return self.send_pushover(
            title=f"⚠️ Warning: {context}",
            message=details,
            priority=NotificationPriority.NORMAL,
            sound=NotificationSound.MAGIC.value
        )

def main():
    """Main entry point - compatible with notify_pushover.sh usage"""
    # Parse command line arguments
    title = sys.argv[1] if len(sys.argv) > 1 else "Webstack Notification"
    message = sys.argv[2] if len(sys.argv) > 2 else "No details provided."
    url = sys.argv[3] if len(sys.argv) > 3 else None
    
    # Send notification
    notifier = Notifier()
    success = notifier.send_pushover(title=title, message=message, url=url)
    
    # Exit with appropriate code
    sys.exit(0 if success else 1)

if __name__ == "__main__":
    main()