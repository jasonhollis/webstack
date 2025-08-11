# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Context
KTP Digital is a premium IT consultancy specializing in enterprise automation and high-end home automation for Melbourne's luxury market. This is a revenue-generating business website undergoing a complete modernization from legacy systems to a new architecture.

## Critical Business Files
- `/opt/webstack/html/premium-landing.php` - PRIMARY REVENUE DRIVER - Google Ads landing page for lead generation
- `/opt/webstack/automation/api/index.php` - Core automation API endpoints
- Database: `premium_leads` table - Stores high-value leads ($25K-$100K+ projects)

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
│   ├── images/icons/        # 60+ integration partner logos
│   └── images/spiral_*.mp4  # Hero video backgrounds
├── automation/              # Backend automation engine
│   ├── api/                # REST API endpoints
│   └── lib/                # Core libraries (Database.php, JobQueueManager.php)
└── client-portal/          # Client dashboard interface
```

### Database Schema Highlights
- `premium_leads`: Lead capture with budget_range, suburb, utm tracking
- `automation_jobs`: Job queue for background processing
- `companies` & `users`: Multi-tenant client management
- `client_projects`: Track project values and device installations

## Critical Business Rules

1. **Lead Generation Priority**: The premium-landing.php page must always remain functional and optimized for conversion
2. **Professional Tone**: Maintain enterprise-grade messaging - avoid consumer/DIY language
3. **Target Market**: Focus on Melbourne premium suburbs (Toorak, Brighton, Armadale)
4. **Project Values**: Emphasize $25K-$100K+ projects, not small consumer jobs
5. **Brand Consistency**: Use established color scheme (#1e40af blue, #d97706 gold)

## Code Standards

### Shell Script Development
**CRITICAL: All shell scripts must use failure.sh for error handling**
- Every critical command should check exit status
- Use pattern: `command || { "$FAILURE_SH" "script_name" "error message"; exit 1; }`
- This ensures Pushover notifications and logging on failures
- Example:
  ```bash
  git add -A || { "$FAILURE_SH" "update_version.sh" "git add failed"; exit 1; }
  ```
- Non-critical operations can use `|| echo "Warning..."` to continue
- All scripts being migrated to Python (see roadmap)

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

## Integration Partners
The site integrates with premium automation brands. Icons available in `/html/images/icons/`:
- Tesla (Powerwall), Sonos, UniFi, Apple HomeKit
- Zigbee, Z-Wave, Matter, Ring, Philips Hue
- 60+ other premium brand integrations

## Development Methodology

### Collaborative Iteration Process
When working with Claude on this project, we follow a structured iterative approach:

1. **Version-Based Development**
   - Each work session starts with reviewing current version objectives
   - Work is tracked in `/objectives/vX.X.X_objectives.md`
   - Progress documented in `/objectives/vX.X.X_iteration_log.md`
   - Version bumps via `/opt/webstack/bin/update_version.sh` when objectives complete

2. **Iteration Workflow**
   - Start: Review objectives and current version status
   - Execute: Implement features with real-time progress tracking
   - Document: Update iteration log with achievements and metrics
   - Complete: Run version bump, create git tag, push to remote
   - Plan: Define next version objectives based on roadmap

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
- **Iteration Log** (`/admin/logs.php`): View current version's iteration progress
- **Objectives Log** (`/admin/objectives.php`): Track version objectives and completion
- **Roadmap** (`/admin/roadmap.php`): Long-term development planning
- **Analytics** (`/admin/analytics.php`): Web traffic and system metrics
- **Maintenance** (`/admin/maintenance.php`): System health and maintenance tasks
- **File Stats** (`/admin/file_stats.php`): Codebase statistics and analysis
- **System Meta** (`/admin/system_meta.php`): System configuration and metadata
- **Screenshots** (`/admin/screenshot-upload.php`): Development screenshot management
- **AI Directives** (`/admin/directives.php`): View PROJECT_DIRECTIVES.md
- **Claude MD** (`/admin/claude-md.php`): View this CLAUDE.md file with proper formatting

## Testing Checklist
When making changes, verify:
1. Lead capture form submits to premium_leads table
2. Automation API endpoints return JSON responses
3. Client portal authentication works
4. Mobile responsiveness on all pages
5. Video backgrounds load properly
6. No PHP errors in logs

## Current Development Focus

### Recent Achievements (v1.8.6-v1.8.7)
- **Database Logging Infrastructure**: Complete migration from file-based to database logging
- **Python DatabaseLogger**: Comprehensive logging class with shell integration via db_log.py
- **Analytics Enhancement**: Dual logging system with UTM tracking and bot detection
- **Git Cleanup**: Removed 35,747 lines of logs from version control
- **Performance**: Query speed now instant (was seconds with grep)
- **Admin System Fixes**: Resolved session handling issues and screenshot upload permissions
- **Claude MD Viewer**: Added dedicated admin panel page for viewing CLAUDE.md with proper markdown rendering

### Active Development Areas (v1.8.x-v1.9.0)
- **Database-Driven Operations**: All system operations now logged to MySQL tables
- **Python Migration**: Priority - Converting critical bash scripts (update_version.sh, snapshot_webstack.sh) to Python
- **Lead Management**: Building admin dashboard for premium_leads table management
- **Analytics System**: SQL-based analytics replacing file grep operations
- **Admin Panel**: Enhancing admin tools with iteration logs, objectives tracking, and AI instruction viewer

### Infrastructure Improvements
- 10+ logging tables: version_history, operation_logs, web_analytics, error_logs, etc.
- Automatic retention policies with MySQL events
- Transaction support and proper error handling
- Real-time dashboard capabilities

### Legacy System Migration
- Shell scripts being replaced with Python modules (DatabaseLogger.py, db_log.py)
- Version tracking enhanced with database audit trail (v1.8.7 current)
- File-based logs maintained for backwards compatibility during transition
- Next major milestone: v1.9.0 - Complete Python infrastructure migration

## Important Workflow Rules

### File Editing Best Practices
**CRITICAL: Always edit files in place - NEVER create multiple versions**
- Edit existing files directly rather than creating v2, v3, v4 versions
- The version control system (`/opt/webstack/bin/update_version.sh`) handles version management
- Creating multiple file versions causes confusion and breaks the established workflow
- Example: Edit `premium-landing.php` directly, don't create `premium-landing-v2.php`

### Version Management System
- The project uses a sophisticated version control system via `update_version.sh`
- This script handles version bumps, git commits, tagging, and iteration logs
- Current version is tracked in `/opt/webstack/html/VERSION`
- Objectives for each version are in `/opt/webstack/objectives/`
- The system automatically creates markdown-based iteration logs

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