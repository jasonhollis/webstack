#!/usr/bin/env python3
"""
Analytics Migration Script - Migrate web analytics from flat file to database
Preserves historical data while supporting enhanced tracking features
"""

import json
import re
import sys
import os
from datetime import datetime
from typing import Dict, Any, Optional, Tuple
import pymysql
from pymysql.cursors import DictCursor

# Add automation lib to path
sys.path.append('/opt/webstack/automation/lib')
from DatabaseLogger import DatabaseLogger

class AnalyticsMigrator:
    """Migrate analytics data from flat files to database"""
    
    def __init__(self):
        self.logger = DatabaseLogger()
        self.bot_patterns = [
            r'(bot|crawl|spider|scraper|curl|wget|python|zgrab|scanner)',
            r'(googlebot|bingbot|facebookexternalhit|twitterbot)',
            r'(gptbot|oai-searchbot|searchbot)',
            r'(facebot|slurp|duckduckgo|baidu|yandex)'
        ]
        self.compiled_bot_patterns = [re.compile(pattern, re.IGNORECASE) for pattern in self.bot_patterns]
    
    def detect_bot(self, user_agent: str) -> Tuple[bool, Optional[str]]:
        """Detect if user agent is a bot and return bot name"""
        if not user_agent or user_agent == 'unknown':
            return False, None
            
        for pattern in self.compiled_bot_patterns:
            match = pattern.search(user_agent)
            if match:
                return True, match.group(1).lower()
        
        return False, None
    
    def parse_device_type(self, user_agent: str) -> str:
        """Simple device type detection from user agent"""
        if not user_agent or user_agent == 'unknown':
            return 'unknown'
            
        ua_lower = user_agent.lower()
        
        # Check for bots first
        is_bot, _ = self.detect_bot(user_agent)
        if is_bot:
            return 'bot'
            
        # Check for mobile indicators
        mobile_indicators = ['mobile', 'android', 'iphone', 'ipad', 'ipod', 'windows phone']
        if any(indicator in ua_lower for indicator in mobile_indicators):
            if 'ipad' in ua_lower or 'tablet' in ua_lower:
                return 'tablet'
            return 'mobile'
            
        return 'desktop'
    
    def parse_browser_os(self, user_agent: str) -> Tuple[Optional[str], Optional[str]]:
        """Extract browser and OS from user agent"""
        if not user_agent or user_agent == 'unknown':
            return None, None
            
        browser = None
        os = None
        
        # Browser detection
        if 'chrome/' in user_agent.lower():
            browser = 'Chrome'
        elif 'firefox/' in user_agent.lower():
            browser = 'Firefox'
        elif 'safari/' in user_agent.lower() and 'chrome' not in user_agent.lower():
            browser = 'Safari'
        elif 'edge/' in user_agent.lower():
            browser = 'Edge'
        elif 'bot' in user_agent.lower():
            browser = 'Bot'
        
        # OS detection
        ua_lower = user_agent.lower()
        if 'windows' in ua_lower:
            os = 'Windows'
        elif 'macintosh' in ua_lower or 'mac os' in ua_lower:
            os = 'macOS'
        elif 'linux' in ua_lower:
            os = 'Linux'
        elif 'android' in ua_lower:
            os = 'Android'
        elif 'iphone' in ua_lower or 'ipad' in ua_lower:
            os = 'iOS'
        
        return browser, os
    
    def parse_log_entry(self, json_line: str) -> Optional[Dict[str, Any]]:
        """Parse a single JSON log entry"""
        try:
            entry = json.loads(json_line.strip())
            
            # Convert timestamp format
            timestamp_str = entry.get('ts', '')
            try:
                timestamp = datetime.strptime(timestamp_str, '%Y-%m-%d %H:%M:%S')
            except ValueError:
                print(f"Warning: Invalid timestamp format: {timestamp_str}")
                return None
            
            # Extract basic fields
            ip = entry.get('ip', 'unknown')
            page = entry.get('page', '/')
            user_agent = entry.get('ua', 'unknown')
            referer = entry.get('referer', '')
            if referer == '-':
                referer = None
            
            status_code = entry.get('status', 200)
            load_time_raw = entry.get('load_time', 0)
            
            # Convert load time from seconds to milliseconds
            try:
                load_time_ms = int(float(load_time_raw) * 1000)
            except (ValueError, TypeError):
                load_time_ms = 0
            
            # Bot detection
            is_bot, bot_name = self.detect_bot(user_agent)
            
            # Device type detection
            device_type = self.parse_device_type(user_agent)
            
            # Browser and OS detection
            browser, os = self.parse_browser_os(user_agent)
            
            # Parse query string from page URL
            query_string = None
            if '?' in page:
                page_parts = page.split('?', 1)
                page = page_parts[0]
                query_string = page_parts[1]
            
            return {
                'timestamp': timestamp,
                'ip': ip,
                'page': page,
                'query_string': query_string,
                'user_agent': user_agent,
                'browser': browser,
                'os': os,
                'device_type': device_type,
                'referer': referer,
                'status_code': status_code,
                'load_time_ms': load_time_ms,
                'is_bot': is_bot,
                'bot_name': bot_name,
                'session_id': None,  # Not available in legacy data
                'utm_source': None,  # Not available in legacy data
                'utm_medium': None,  # Not available in legacy data
                'utm_campaign': None  # Not available in legacy data
            }
            
        except json.JSONDecodeError as e:
            print(f"Warning: Invalid JSON in log entry: {e}")
            return None
        except Exception as e:
            print(f"Warning: Error parsing log entry: {e}")
            return None
    
    def migrate_file(self, log_file_path: str) -> Tuple[int, int, int]:
        """Migrate analytics data from file to database"""
        if not os.path.exists(log_file_path):
            print(f"Error: Log file not found: {log_file_path}")
            return 0, 0, 0
        
        total_lines = 0
        processed = 0
        errors = 0
        
        print(f"Starting migration from {log_file_path}")
        
        with open(log_file_path, 'r', encoding='utf-8') as f:
            for line_num, line in enumerate(f, 1):
                total_lines += 1
                
                if line_num % 100 == 0:
                    print(f"Processed {line_num} lines...")
                
                parsed_entry = self.parse_log_entry(line)
                if not parsed_entry:
                    errors += 1
                    continue
                
                try:
                    self.insert_analytics_record(parsed_entry)
                    processed += 1
                except Exception as e:
                    print(f"Error inserting record at line {line_num}: {e}")
                    errors += 1
        
        return total_lines, processed, errors
    
    def insert_analytics_record(self, record: Dict[str, Any]):
        """Insert a single analytics record into the database"""
        with self.logger.get_connection() as conn:
            with conn.cursor() as cursor:
                cursor.execute("""
                    INSERT INTO web_analytics 
                    (timestamp, ip, page, query_string, user_agent, browser, os, 
                     device_type, referer, status_code, load_time_ms, is_bot, 
                     session_id, utm_source, utm_medium, utm_campaign)
                    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
                """, (
                    record['timestamp'],
                    record['ip'],
                    record['page'], 
                    record['query_string'],
                    record['user_agent'],
                    record['browser'],
                    record['os'],
                    record['device_type'],
                    record['referer'],
                    record['status_code'],
                    record['load_time_ms'],
                    record['is_bot'],
                    record['session_id'],
                    record['utm_source'],
                    record['utm_medium'],
                    record['utm_campaign']
                ))
    
    def verify_migration(self) -> Dict[str, Any]:
        """Verify the migration results"""
        with self.logger.get_connection() as conn:
            with conn.cursor() as cursor:
                # Get total record count
                cursor.execute("SELECT COUNT(*) as total FROM web_analytics")
                total_records = cursor.fetchone()['total']
                
                # Get date range
                cursor.execute("""
                    SELECT 
                        MIN(timestamp) as earliest_date,
                        MAX(timestamp) as latest_date
                    FROM web_analytics
                """)
                date_range = cursor.fetchone()
                
                # Get bot statistics
                cursor.execute("""
                    SELECT 
                        COUNT(*) as total_bots,
                        COUNT(DISTINCT ip) as unique_bot_ips
                    FROM web_analytics 
                    WHERE is_bot = 1
                """)
                bot_stats = cursor.fetchone()
                
                # Get device type breakdown
                cursor.execute("""
                    SELECT device_type, COUNT(*) as count 
                    FROM web_analytics 
                    GROUP BY device_type
                    ORDER BY count DESC
                """)
                device_stats = cursor.fetchall()
                
                return {
                    'total_records': total_records,
                    'date_range': date_range,
                    'bot_stats': bot_stats,
                    'device_stats': device_stats
                }

def main():
    """Main migration function"""
    log_file = '/opt/webstack/logs/web_analytics.log'
    
    print("=" * 60)
    print("KTP Digital - Web Analytics Migration")
    print("=" * 60)
    
    migrator = AnalyticsMigrator()
    
    # Check if database is empty
    with migrator.logger.get_connection() as conn:
        with conn.cursor() as cursor:
            cursor.execute("SELECT COUNT(*) as count FROM web_analytics")
            existing_count = cursor.fetchone()['count']
    
    if existing_count > 0:
        response = input(f"Database already contains {existing_count} records. Continue anyway? (y/N): ")
        if response.lower() != 'y':
            print("Migration cancelled.")
            return
    
    # Perform migration
    total_lines, processed, errors = migrator.migrate_file(log_file)
    
    print("\nMigration Results:")
    print(f"  Total lines in log file: {total_lines}")
    print(f"  Successfully processed: {processed}")
    print(f"  Errors encountered: {errors}")
    print(f"  Success rate: {(processed/total_lines)*100:.1f}%" if total_lines > 0 else "  Success rate: 0%")
    
    # Verification
    if processed > 0:
        print("\nVerifying migration...")
        verification = migrator.verify_migration()
        
        print(f"\nDatabase Verification:")
        print(f"  Total records: {verification['total_records']}")
        print(f"  Date range: {verification['date_range']['earliest_date']} to {verification['date_range']['latest_date']}")
        print(f"  Bot records: {verification['bot_stats']['total_bots']} ({verification['bot_stats']['unique_bot_ips']} unique IPs)")
        
        print(f"\nDevice Type Breakdown:")
        for device_stat in verification['device_stats']:
            print(f"  {device_stat['device_type']}: {device_stat['count']}")
    
    print("\nMigration completed!")

if __name__ == "__main__":
    main()