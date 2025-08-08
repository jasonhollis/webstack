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

### Tech Stack
- **Server**: Debian 12 Linux on SSDNodes VPS
- **Web**: nginx 1.22.1 + PHP 8.2-FPM
- **Database**: MariaDB 10.11.11 (database: ktp_digital)
- **Frontend**: Tailwind CSS (CDN), Adobe bank-gothic-bt font
- **Domain**: www.ktp.digital

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

## Testing Checklist
When making changes, verify:
1. Lead capture form submits to premium_leads table
2. Automation API endpoints return JSON responses
3. Client portal authentication works
4. Mobile responsiveness on all pages
5. Video backgrounds load properly
6. No PHP errors in logs

## Current Development Focus

### Active Rewrite Areas
- **New Architecture**: Modern PHP 8.2 with proper separation of concerns
- **Automation System**: Building out `/automation/` with job queue management
- **Client Portal**: New dashboard at `/client-portal/` for client management
- **API Development**: RESTful endpoints in `/automation/api/`

### Legacy System Notes
- Old directives in `/objectives/PROJECT_DIRECTIVES.md` are from pre-rewrite phase
- Legacy scripts in `/opt/webstack/bin/` being phased out
- Version tracking system (v1.7.5) will be replaced with modern CI/CD

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

## Important Business Notes
- This is a LIVE revenue-generating website - test all changes carefully
- Target market: Melbourne premium suburbs ($25K-$100K+ projects)
- Maintain enterprise-grade professional tone
- The premium-landing.php file is CRITICAL for Google Ads campaigns
- Focus on high-net-worth individuals and enterprise clients
- Brand consistency: Use established colors (#1e40af blue, #d97706 gold)