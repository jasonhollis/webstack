# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Context
KTP Digital is a premium IT consultancy specializing in enterprise automation and high-end home automation for Melbourne's luxury market. This is a revenue-generating business website undergoing a complete modernization from legacy systems to a new architecture.

## Critical Business Files
- `/opt/webstack/html/premium-landing.php` - PRIMARY REVENUE DRIVER - Google Ads landing page with deep content links
- `/opt/webstack/html/premium-landing-spiral.php` - ✅ v2.1.0 NEW - Dark theme with spiral video background
- `/opt/webstack/html/premium-landing-spiral-test.php` - ✅ v2.1.0 NEW - Light theme for A/B testing
- `/opt/webstack/html/api/postcode_lookup.php` - ✅ v2.1.0 NEW - Australian postcode/suburb API
- `/opt/webstack/html/js/postcode_autocomplete.js` - ✅ v2.1.0 NEW - Autocomplete for forms
- `/opt/webstack/html/lead_form.php` - ✅ v2.0.8 FIXED - Budget scoring uses ranges instead of tiers
- `/opt/webstack/html/home_automation_form.php` - ✅ v2.1.0 UPDATED - Universal form, no suburb restrictions
- `/opt/webstack/html/small_business_form.php` - Mac/IT services form with urgency tracking
- `/opt/webstack/html/network_infrastructure_form.php` - Enterprise network form ($150K+ projects)
- `/opt/webstack/html/contact.php` - General contact form (working, saves to DB)
- `/opt/webstack/html/nav_enhanced.php` - ✅ v2.0.8 NEW - Dropdown navigation linking 30+ pages
- `/opt/webstack/html/services.php` - ✅ v2.0.8 NEW - Complete service directory
- `/opt/webstack/html/robots.txt` - ✅ v2.0.8 NEW - SEO crawling rules
- `/opt/webstack/html/sitemap.xml` - ✅ v2.0.8 NEW - Complete sitemap for Google
- `/opt/webstack/html/.well-known/mta-sts.txt` - ✅ v2.0.8 NEW - Email security policy
- `/opt/webstack/automation/api/index.php` - Core automation API endpoints
- Database: `premium_leads` table - Stores leads with scoring, UTM params, estimated value, postcode

## Common Development Commands

### Service Management
```bash
# Restart web services after changes
systemctl restart nginx php8.2-fpm

# Check service status
systemctl status nginx php8.2-fpm mariadb

# View nginx logs
tail -f /var/log/nginx/webstack_error.log
tail -f /var/log/nginx/webstack_access.log
```

### Database Operations
```bash
# Access database
mariadb -u root ktp_digital

# Common queries for lead tracking
echo "SELECT * FROM premium_leads ORDER BY created_at DESC LIMIT 10;" | mariadb -u root ktp_digital
```

### Testing & Validation
```bash
# Test PHP syntax
php -l html/premium-landing.php

# Check nginx configuration
nginx -t

# Test automation API
curl -X GET http://localhost/automation/api/health

# Update SSL certificate cache (for System Meta page)
/opt/webstack/bin/cache_ssl_info.sh
```

### Version Management
```bash
# Version bump with statistics (v2.0.6+)
python3 /opt/webstack/bin/update_version.py vX.X.X

# Statistics displayed include:
# - Files changed, insertions, deletions
# - Snapshot size and git commit hash
# - Total commits and repository size
# - Duration and version history count
# - Dual logging to database + files (v2.1.2+)
# All stats are sent via Pushover notification
```

## Architecture Overview

### System Environment
- **OS**: Debian GNU/Linux 12 (bookworm)
- **Kernel**: 6.1.0-37-amd64
- **Hosting**: SSDNodes VPS
- **Last verified**: August 8, 2025

### Tech Stack
- **Web Server**: nginx 1.22.1
- **PHP**: 8.2.28 with PHP-FPM
- **Database**: MariaDB 10.11.11 (database: ktp_digital)
- **Frontend**: Tailwind CSS (CDN), Adobe bank-gothic-bt font
- **Domain**: www.ktp.digital
- **SSL**: Let's Encrypt certificates

### Key Directories
```
/opt/webstack/
├── html/                    # Public website (nginx root)
│   ├── premium-landing.php  # Lead generation landing page
│   ├── images/icons/        # 216+ integration partner logos
│   ├── images/spiral_*.mp4  # Hero video backgrounds
│   └── images/spiral_alpha.mov # Spiral with alpha channel (225MB)
├── automation/              # Backend automation engine
│   ├── api/                # REST API endpoints
│   └── lib/                # Core libraries (Database.php, JobQueueManager.php)
└── client-portal/          # Client dashboard interface
```

### Database Schema Highlights
- `premium_leads`: Lead capture with budget_range, suburb, utm tracking, lead_score, message, project_type
- `automation_jobs`: Job queue for background processing
- `companies` & `users`: Multi-tenant client management
- `client_projects`: Track project values and device installations
- `web_analytics`: Page hits with IP, user agent, load times, UTM params
- `ip_geolocation_cache`: 7-day cache for IP lookups (country, city, org)

## Critical Business Rules

1. **Lead Generation Priority**: The premium-landing.php page must always remain functional and optimized for conversion
2. **Professional Tone**: Maintain enterprise-grade messaging - avoid consumer/DIY language
3. **Target Market**: Serving all Melbourne and Victoria areas (v2.1.0+)
4. **Project Values**: Emphasize $25K-$100K+ projects, not small consumer jobs
5. **Brand Consistency**: Use established color scheme (#1e40af blue, #d97706 gold)

## Code Standards

### Python Script Development (v2.0.4+)
**All critical shell scripts have been migrated to Python**
- Core scripts: `update_version.py`, `failure.py`, `snapshot_manager.py`
- All scripts use dual logging (database + file) as of v2.1.2
- Graceful fallback to file-only logging if database unavailable
- Use `failure.py` for error notifications with Pushover
- Example:
  ```python
  from failure_handler import FailureHandler
  handler = FailureHandler()
  handler.notify_failure("script_name", "error message")
  ```

### PHP Development
- Use PHP 8.2+ features
- Always use PDO with prepared statements for database queries
- Implement proper error logging while showing graceful messages to users
- Include CSRF protection on all forms

### Frontend Guidelines
- Mobile-first responsive design
- Optimize images and lazy-load videos for performance
- Use Tailwind CSS classes via CDN
- Maintain Adobe bank-gothic-bt font for brand consistency

### Database Conventions
- Table/column names: snake_case
- Always index performance-critical queries
- Use transactions for multi-table operations
- Include created_at/updated_at timestamps

## Navigation & SEO Structure (v2.0.8+)

### Navigation System
- **Main Nav**: `/opt/webstack/html/nav.php` - Simple 6-item menu (legacy)
- **Enhanced Nav**: `/opt/webstack/html/nav_enhanced.php` - Dropdown navigation with 30+ pages
- **Services Menu**: `/opt/webstack/html/services_menu.php` - Central service page registry
- **Categories**: Home Automation, Business IT, Network & Security, Cloud & Data, Tools

### SEO Infrastructure
- **robots.txt**: Comprehensive crawl rules, excludes system files, blocks bad bots
- **sitemap.xml**: 30+ content pages with priorities and changefreq
- **Canonical URLs**: All pages have canonical tags to prevent duplicate content
- **MTA-STS**: `.well-known/mta-sts.txt` prevents email daemon hammering
- **System Files Excluded**: 20+ system/test files excluded from SEO tracking

### Critical PHP Fixes
- **analytics_logger.php**: All functions wrapped in `if (!function_exists())` to prevent redeclaration
- **Include Pattern**: Always use `include_once` for files with function definitions

## Integration Partners
The site integrates with premium automation brands. Icons available in `/html/images/icons/`:
- Tesla (Powerwall), Sonos, UniFi, Apple HomeKit
- Zigbee, Z-Wave, Matter, Ring, Philips Hue
- 60+ other premium brand integrations

## External Services
- **IP Geolocation**: ip-api.com (free tier, 45 req/min limit)
  - Cached in `ip_geolocation_cache` table for 7 days
  - Only lookup IPs with 3+ hits to avoid rate limits
- **SSL Monitoring**: Certbot certificates cached to `/tmp/ssl_cert_info.txt`
  - Updated via cron: `/etc/cron.d/ssl-cache`
- **Icon Updates**: Disabled as of v2.1.2 (216 icons sufficient, daily fetching was overkill)
- **Australian Postcode API**: postcodeapi.com.au (free tier, 100 req/hour)
  - Primary source: `/api/postcode_lookup.php`
  - Fallback: Static database of 50+ Victorian postcodes
  - Autocomplete: `/js/postcode_autocomplete.js` with debounced requests
  - Returns: suburb, state, postcode, lat/long

## Video Production Capabilities

### Available Tools & Licenses
**IMPORTANT: The owner has full Adobe Creative Cloud, Final Cut Pro, and Pixelmator Pro licenses**
- Can license and download 4K versions of any Adobe Stock content
- Can create custom videos with alpha channels for transparency
- Can export to any format/resolution/codec required
- File size is NOT a constraint - focus on quality and visual impact

### Video Workflow
1. **Source Selection**: Choose Adobe Stock preview, owner will license 4K version
2. **Editing**: Owner can modify in Final Cut Pro or Adobe Premiere/After Effects:
   - Add/remove alpha channels for transparency
   - Adjust colors, speed, direction
   - Create seamless loops
   - Export at any resolution (4K, 1080p, 720p, mobile-optimized)
3. **Format Conversion**: 
   - Primary editing outputs: .mov with ProRes or H.264
   - Web formats: Use ffmpeg on server for .mp4 and .webm conversion
   - Example: `ffmpeg -i input.mov -c:v libvpx-vp9 -b:v 2M output.webm`

### Current Video Assets
- `/opt/webstack/html/images/spiral_alpha.mov` - Original spiral with alpha channel (225MB)
- Multiple spiral variations in .mp4 format for web use
- Adobe Stock samples in `/opt/webstack/html/test-videos/` for evaluation

### Best Practices
- Request specific modifications rather than compromising on preview files
- Specify if alpha channel is needed for overlay effects
- Consider creating multiple versions: desktop (4K), tablet (1080p), mobile (720p)
- Use .webm with VP9 codec for modern browsers, .mp4 H.264 fallback

## Development Methodology

### CLAUDE.md Update Policy
**IMPORTANT: Before running version bump or at session end, Claude must:**
1. **Analyze session changes** for any new patterns, tools, or infrastructure
2. **Compare against CLAUDE.md** to identify missing documentation
3. **Review CLAUDE.md for quality issues**:
   - **Conflicts**: Contradictory information that needs resolution
   - **Redundancy**: Duplicate information in multiple sections
   - **Stale Info**: Outdated version numbers, completed tasks marked as pending, old file counts
   - **Missing Info**: New features/changes not documented
4. **Update CLAUDE.md** with:
   - New tools/scripts created (location, purpose, usage)
   - Database schema changes or new tables
   - External services/APIs integrated
   - Performance benchmarks discovered
   - Critical file paths or dependencies added
   - Lessons learned that affect future development
   - Fix all conflicts, redundancy, and stale information found
5. **Report to user** what conflicts/redundancy/stale info was found and fixed
6. **Include in iteration summary** what was added to CLAUDE.md

This ensures knowledge persistence across sessions and prevents re-solving problems.

### Collaborative Iteration Process
When working with Claude on this project, we follow a structured iterative approach:

1. **Version-Based Development**
   - Each work session starts with reviewing current version objectives
   - Work is tracked in `/objectives/vX.X.X_objectives.md`
   - Progress documented in `/objectives/vX.X.X_iteration_log.md`
   - Version bumps via `python3 /opt/webstack/bin/update_version.py` when objectives complete

2. **Iteration Workflow**
   - Start: Review objectives and current version status
   - Execute: Implement features with real-time progress tracking
   - Document: Update iteration log with achievements and metrics
   - Complete: Run `python3 /opt/webstack/bin/update_version.py vX.X.X` (handles ALL git operations)
   - Plan: Define next version objectives based on roadmap
   - **NEVER run git commands manually - update_version.py does everything**

3. **Session Pattern**
   - Claude reads recent objectives/iteration logs to understand context
   - User provides specific goals aligned with version objectives
   - Implementation with continuous testing and validation
   - Session ends with comprehensive iteration log update
   - Version bump captures the work as a deployable milestone

4. **Documentation Standards**
   - Every significant change logged with metrics (lines changed, files modified)
   - Problems solved clearly stated with before/after comparison
   - Performance improvements quantified (speed, storage, efficiency)
   - Lessons learned captured for future sessions

### Working with Claude
- Claude maintains context by reading objectives and iteration logs
- Each session builds on previous work documented in version history
- Clear handoff between sessions via detailed iteration logs
- Version control provides rollback points if needed

## Admin Panel Tools
The admin panel (`/admin/`) provides essential development tools:
- **Iteration Log** (`/admin/logs.php`): View current version's iteration progress (📥 Download button v2.1.3+)
- **Objectives Log** (`/admin/objectives.php`): Track version objectives and completion (📥 Download button v2.1.3+)
- **Roadmap** (`/admin/roadmap.php`): Long-term development planning (📥 Download button v2.1.3+)
- **Analytics** (`/admin/analytics.php`): Web traffic and system metrics
- **Maintenance** (`/admin/maintenance.php`): System health and maintenance tasks
- **File Stats** (`/admin/file_stats.php`): Codebase statistics and analysis
- **System Meta** (`/admin/system_meta.php`): System configuration and metadata
- **Screenshots** (`/admin/screenshot-upload.php`): Development screenshot management
- **AI Directives** (`/admin/directives.php`): View PROJECT_DIRECTIVES.md
- **Claude MD** (`/admin/claude-md.php`): View this CLAUDE.md file with proper formatting (📥 Download button v2.1.3+)

## Testing Checklist
When making changes, verify:
1. Lead capture form submits to premium_leads table
2. Automation API endpoints return JSON responses
3. Client portal authentication works
4. Mobile responsiveness on all pages
5. Video backgrounds load properly
6. No PHP errors in logs

## Revenue Optimization Achievements

### Lead Capture System (v2.0.7-v2.1.0) ✅ COMPLETE
- **Specialized Forms Created**:
  - ✅ home_automation_form.php - Premium HA with suburb targeting
  - ✅ small_business_form.php - Mac/IT with urgency tracking
  - ✅ network_infrastructure_form.php - Enterprise networking ($150K+)
  - ⏳ quick_contact.php - Simple form (next iteration)

- **Lead Scoring System Implemented**:
  - ✅ Premium suburbs = +15-20 points
  - ✅ Integration/feature count = ×5 points each
  - ✅ Urgency/timeline = +5-15 points
  - ✅ Budget range = up to +25 points
  - ✅ Stored in premium_leads.lead_score column

- **Content Issues Fixed**:
  - ✅ Mac pages "I've" → professional language
  - ✅ Trust signals added to premium-landing.php
  - ⏳ integration_grid_test.php simplification (pending)
  - ⏳ Case studies pages (next iteration)

## Current Development Focus

### Recent Achievements (v2.0.0-v2.0.8)
- **Navigation Architecture (v2.0.8)**: Created dropdown nav system linking 30+ orphaned pages
- **SEO Infrastructure (v2.0.8)**: Complete robots.txt, sitemap.xml, canonical URLs on all pages
- **Critical Bug Fixes (v2.0.8)**: Fixed analytics_logger.php function redeclaration errors
- **Performance (v2.0.8)**: System Meta page loads instantly after excluding system files
- **MTA-STS Fix (v2.0.8)**: Stopped daemon hammering with proper .well-known files
- **Revenue Optimization (v2.0.7)**: Fixed critical lead_form.php database save issue
- **Specialized Forms (v2.0.7)**: Created 3 targeted forms with lead scoring and UTM tracking
- **Lead Scoring System (v2.0.7)**: Automatic scoring based on suburb, budget, urgency
- **HubSpot Integration (v2.0.7)**: Email subject tagging for lead categorization
- **Trust Signals (v2.0.7)**: Added credibility metrics to premium-landing.php
- **Professional Language (v2.0.7)**: Fixed all first-person references to corporate voice
- **Version Manager Statistics (v2.0.6)**: Added comprehensive deployment metrics with Pushover
- **Git Repository Cleanup (v2.0.6)**: Removed 630MB of video files from history
- **Python Script Migration (v2.0.4)**: ✅ All critical bash scripts now Python
- **Dual Logging Infrastructure**: Phase 1 complete - all scripts log to both DB and files
- **Analytics Enhancement**: IP geolocation with caching, UTM tracking, bot detection
- **Admin System Fixes**: Resolved session handling, added Claude MD viewer

### Database Logging Migration (v2.1.x series)
- **Phase 1**: ✅ COMPLETE (v2.1.2) - Dual logging implemented
  - update_version.py: Enhanced with version_history + operation_logs
  - failure.py: Dual logging with Pushover alerts maintained
  - snapshot_manager.py: Dual logging with operation tracking
  - test_dual_logging.py: Test framework for validation
- **Phase 2**: ⏳ PENDING - Emergency.log fallback mechanism
- **Phase 3**: ⏳ PENDING - Admin log viewer tools
- **Phase 4**: ⏳ PENDING - 2-week parallel monitoring
- **Phase 5**: ⏳ PENDING - File log deprecation
- **Database-Driven Operations**: All system operations logged to MySQL tables
  - Tables: operation_logs, error_logs, version_history, cleanup_logs
  - DatabaseLogger class in `/opt/webstack/automation/lib/`
- **Python Migration**: ✅ COMPLETED (v2.0.4) - All critical bash scripts migrated
- **Version Management**: Use `python3 bin/update_version.py vX.X.X` for version bumps
- **Lead Management**: Active lead capture on premium-landing.php and contact.php
- **Analytics System**: SQL-based analytics with IP geolocation caching
- **Admin Panel**: Full suite of tools including System Meta, Iteration Logs, Objectives tracking
- **Performance Standards**: Admin pages should load in <20ms, disable expensive operations by default

### Infrastructure Improvements
- 10+ logging tables: version_history, operation_logs, web_analytics, error_logs, etc.
- Automatic retention policies with MySQL events
- Transaction support and proper error handling
- Real-time dashboard capabilities

### Migration Completed
- ✅ All shell scripts replaced with Python modules (v2.0.4)
- ✅ Version tracking enhanced with database audit trail
- ✅ Python migration milestone achieved
- ✅ Dual logging infrastructure operational (v2.1.2)

## Logging Architecture

### Dual Logging Strategy (v2.0.3+)
**Current State:** Parallel logging to both database and files during migration
- **Database First**: Try DatabaseLogger for structured queries
- **File Fallback**: Maintain file logs for emergency debugging
- **Graceful Degradation**: If DB unavailable, continue with files only
- **Migration Timeline**: 5-6 weeks to complete transition

### DatabaseLogger Usage
```python
from DatabaseLogger import DatabaseLogger
db_logger = DatabaseLogger()

# Start operation
op_id = db_logger.log_operation(
    operation_type='version_bump',
    operation_name='v1.0 → v2.0', 
    script_path='script.py'
)

# Log errors (correct parameter order)
db_logger.log_error(
    error_level='critical',  # or 'error', 'warning'
    error_source='context',
    error_message='Details of the error'
)

# Complete operation (no metadata parameter)
db_logger.complete_operation(
    operation_id=op_id,
    status='success',  # or 'failed'
    exit_code=0,
    stdout='Operation output',
    stderr='Any errors'
)
```

### Key Tables
- `operation_logs`: Track all system operations
  - operation_type: enum('version_bump','snapshot','git_push','cleanup','backup','restore','api_call','cron_job','manual_script')
  - status: enum('started','running','success','failed','timeout','cancelled')
- `error_logs`: Capture failures and issues
- `version_history`: Version bump audit trail
  - status: enum('started','snapshot_complete','committed','tagged','pushed','failed','rolled_back')
- `ip_geolocation_cache`: 7-day TTL for IP lookups

## Important Workflow Rules

### File Editing Best Practices
**CRITICAL: Always edit files in place - NEVER create multiple versions**
- Edit existing files directly rather than creating v2, v3, v4 versions
- The version control system (`/opt/webstack/bin/update_version.py`) handles version management
- Creating multiple file versions causes confusion and breaks the established workflow
- Example: Edit `premium-landing.php` directly, don't create `premium-landing-v2.php`

### Version Management System
**CRITICAL: NEVER run git commands directly! Use update_version.py for ALL git operations**
- The project uses a sophisticated version control system via `update_version.py`
- This Python script handles ALL: version bumps, git commits, tagging, pushing, and iteration logs
- DO NOT use: `git add`, `git commit`, `git push`, `git tag` - update_version.py does it all
- Current version is tracked in `/opt/webstack/html/VERSION`
- Objectives for each version are in `/opt/webstack/objectives/`
- The system automatically creates markdown-based iteration logs
- Just run: `python3 /opt/webstack/bin/update_version.py vX.X.X` and it handles everything

## Development Priorities

### Immediate Focus
1. **Lead Generation**: Ensure premium-landing.php continues converting Google Ads traffic
2. **Automation API**: Build robust job processing system
3. **Client Portal**: Create professional dashboard for project management
4. **Database Integration**: Leverage premium_leads table for CRM functionality

### Migration Strategy
- Maintain existing revenue-generating pages during rewrite
- Build new components alongside legacy code
- Test thoroughly before replacing production features
- Keep professional appearance throughout transition
- **ALWAYS edit files in place - the version system handles tracking**

## Site Architecture Details

### Navigation Structure
- **Standard Navigation**: Located in `/opt/webstack/html/nav.php`, included via layout.php
- **Navigation Links**: Home, Small Business, Enterprise, Automation, About, Contact
- **Layout System**: `layout.php` provides renderLayout() function for consistent page structure
- **Premium Landing**: `premium-landing.php` is a standalone Google Ads landing page with custom nav

### Design Elements
- **Brand Font**: Adobe bank-gothic-bt (loaded via Typekit: zqf3vpv.css)
- **Hero Video**: Spiral animation videos in multiple formats (spiral_*.mp4/webm)
- **Color Scheme**: 
  - Primary blue: #1e40af / #3b82f6
  - Accent gold: #d97706
  - Cyan highlights: #06b6d4
- **Logo Files**: 
  - Main logo: `/images/logos/KTP Logo.png` (1821x1866px, 1.4MB)
  - Dark mode: `/images/logos/KTP Logo2.png`
  - Constrained to 32px height in nav.php for proper display

### Page Structure & Content Standards

#### Core Pages Status
- **Homepage** (`index.php`): Card-based service grid layout ✓ Working
- **Contact** (`contact.php`): Full contact form with database integration ✓ Enhanced
- **About** (`about.php`): Professional company overview with metrics ✓ Enhanced  
- **Email** (`email.php`): Microsoft 365 and email services ✓ Working
- **Premium Landing** (`premium-landing.php`): Home Automation focus for Google Ads ✓ Working
  - Custom navigation with anchor links
  - Full-screen spiral video background
  - Lead capture form to premium_leads table
  - Mobile-responsive with Tailwind CSS

#### Content Guidelines for Professional Pages
- **Hero sections**: Clear value proposition, enterprise-focused messaging
- **Metrics/Trust indicators**: Years experience, projects delivered, technology managed
- **Service cards**: Visual cards with icons, hover effects, clear descriptions
- **Target market references**: Always mention Toorak, Brighton, Armadale for premium positioning
- **CTAs**: Dual CTAs (primary: Schedule Consultation, secondary: View Services)
- **Professional tone**: "White glove", "enterprise-grade", "premium", avoid consumer language

### Layout System Details
- **Two Layout Files**:
  - `layout.php`: Standard layout with renderLayout() function for most pages
  - `layout-new.php`: Enhanced layout with render_layout() function, used by premium-landing.php
- **Key Differences**:
  - layout-new.php includes Tailwind CSS via CDN
  - layout-new.php supports bank-gothic font conditional loading
  - Both include nav.php for consistent navigation

### Common Technical Issues & Solutions

#### Include/Require Conflicts
- **Problem**: Functions being redeclared when files are included multiple times
- **Solution**: Always use `include_once` or `require_once` for files containing function definitions
- **Files affected**: analytics_logger.php frequently included in both page files and nav.php
- **Pattern**: `<?php include_once __DIR__."/analytics_logger.php"; ?>`

#### Database Integration Pattern
- **Lead capture**: All forms should save to `premium_leads` table
- **Required fields**: name, email, phone, message, suburb, ip_address, source
- **Form handling**: POST to same page, redirect with ?success=1 after insert
- **Error handling**: Catch exceptions, show user-friendly error messages

#### Color/Theme Consistency
- **Issue**: Many older files use dark theme colors (text-gray-300) on light backgrounds
- **Standard colors**: 
  - Text: text-gray-900 (headings), text-gray-700/600 (body)
  - Backgrounds: white, gray-50 for cards
  - Accents: blue-600, green-600 for positive actions
- **Always check**: Color contrast when updating pages from dark to light theme

### Technical Issues Fixed (Session: 2025-01-11)
- `layout.php` was incomplete (missing renderLayout function) - rebuilt with proper structure
- Navigation links updated to use absolute paths (/, /automation.php, etc.)
- Removed placeholder 1300 number from premium-landing.php
- Added explicit CSS constraints to logo (max-height: 32px) to prevent display issues
- Fixed cookie banner styling with proper dark background and positioning
- Fixed duplicate analytics_logger.php includes causing fatal errors
- Enhanced contact.php with full contact form and database integration
- Updated about.php from basic dark-themed page to professional enterprise presentation
- Fixed email.php dark theme elements for proper display on light background

## Important Business Notes
- This is a LIVE revenue-generating website - test all changes carefully
- Target market: Melbourne premium suburbs ($25K-$100K+ projects)
- Maintain enterprise-grade professional tone
- The premium-landing.php file is CRITICAL for Google Ads campaigns (Home Automation focused)
- Focus on high-net-worth individuals and enterprise clients
- Brand consistency: Use established colors (#1e40af blue, #d97706 gold)