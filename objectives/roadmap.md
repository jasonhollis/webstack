# KTP Digital Development Roadmap
*Last Updated: Friday, August 8, 2025 - 18:15 Melbourne Time*

## Current Version: v1.7.5
## Next Version: v1.8.0 (Major Architecture Update)

---

## 🚀 v1.8.0 - Premium Landing & Lead Management (August 2025)

### Objectives
- Launch premium landing page for Google Ads campaigns
- Implement lead capture and management system
- Create modern layout wrapper for consistent design
- Establish database-driven analytics

### Completed
- ✅ Fixed layout.php system (created layout-new.php)
- ✅ Built premium-landing-v4.php with spiral video
- ✅ Screenshot upload system for development workflow
- ✅ Database schema for premium_leads table
- ✅ Achieved optimal spiral contrast with content box

### In Progress
- [ ] Create /admin/leads.php for lead management
- [ ] Email notifications for new leads
- [ ] UTM parameter tracking for ROI analysis

---

## 📊 v1.9.0 - Analytics & Conversion Tracking (September 2025)

### Planned Features
- Enhanced analytics dashboard with conversion funnel
- Lead source attribution and ROI tracking
- A/B testing framework for landing pages
- Real-time visitor behavior tracking
- Google Ads integration for cost per lead

### Database Requirements
- Create analytics_events table
- Add conversion tracking fields to premium_leads
- Session tracking and user journey mapping

---

## 👥 v2.0.0 - Client Portal Launch (October 2025)

### Major Milestone Features
- Client login system using users/companies tables
- Project status dashboard
- Document library for manuals/guides
- Support ticket system
- Invoice viewing and payment

### Technical Requirements
- Activate user authentication system
- Build project management tables
- Implement role-based access control
- Create client-specific dashboards

---

## 🔧 v2.1.0 - Automation Monitoring (November 2025)

### Home Assistant Integration
- Remote system health monitoring
- Device failure alerts
- Usage pattern analytics
- Automated backup verification
- Energy consumption tracking

### Implementation
- Repurpose automation_jobs table
- Build REST API for HA integration
- Create monitoring dashboard
- Implement alert system via Pushover

---

## 💼 v2.2.0 - CRM & Project Management (December 2025)

### Business Process Automation
- Lead to project conversion workflow
- Milestone and deliverable tracking
- Technician scheduling system
- Inventory management
- Quote and proposal generation

### Database Expansion
- Projects and milestones tables
- Inventory tracking system
- Scheduling calendar integration
- Document management system

---

## 🎯 v3.0.0 - Enterprise Platform (Q1 2026)

### Platform Evolution
- Multi-tenant SaaS architecture
- White-label options for partners
- Subscription billing system
- Partner portal
- API marketplace

### Revenue Streams
- Monthly recurring revenue from partners
- Transaction fees on projects
- Premium feature tiers
- Training and certification programs

---

## 📈 Success Metrics

### 30-Day Goals (by September 2025)
- 10+ qualified leads captured
- 5% landing page conversion rate
- <2 hour lead response time
- 3+ projects from web leads

### 90-Day Goals (by November 2025)
- 50+ total leads in database
- $200K+ pipeline value
- Client portal with 10+ active users
- Automated follow-up sequences live

### 12-Month Goals (by August 2026)
- 200+ completed projects
- $2M+ revenue tracked
- 50+ active client portal users
- 5+ white-label partners

---

## 🔧 Technical Debt Backlog

### High Priority
1. Migrate from layout.php to layout-new.php
2. Consolidate landing page versions
3. Optimize video assets (multiple spiral formats)
4. Implement proper error logging
5. **CRITICAL: Convert all bash scripts to Python with database logging**
   - update_version.sh → Python version manager with DB audit trail
   - snapshot_webstack.sh → Python backup system with verification
   - failure.sh → Python error handler with structured logging
   - notify_pushover.sh → Python notification service with retry logic
   - All operations logged to database, not just text files
   - Proper exception handling instead of exit codes
   - Unit tests for all critical functions
   - Progress tracking and rollback capabilities
   - Benefits: Reliability, testability, audit trail, better error recovery

### Medium Priority
1. Standardize navigation across all pages
2. Clean up legacy /bin scripts
3. Implement CSS/JS bundling
4. Add unit tests for critical functions

### Low Priority
1. Documentation updates
2. Code commenting standards
3. Performance optimization
4. SEO enhancements

---

## 📝 Version Naming Convention

- **Major (X.0.0)**: Platform features (Client Portal, SaaS)
- **Minor (1.X.0)**: New functionality (Analytics, CRM)
- **Patch (1.8.X)**: Bug fixes and improvements
- **Dev tags**: Feature branches (v1.8.0-analytics)

---

## 🚦 Current Sprint (v1.8.4)

### Immediate Priority - Lead Management Dashboard
1. Create /admin/leads.php to view captured leads
2. Add status tracking (new → contacted → qualified → converted)
3. Email notifications for new leads
4. CSV export functionality
5. Test with live Google Ads campaign

---

## 🐍 v1.9.0 - Python Infrastructure Migration (Critical)

### Replace Shell Scripts with Python
1. **Version Manager** (`/opt/webstack/lib/version_manager.py`)
   - Replace update_version.sh
   - Database audit trail in `version_history` table
   - Atomic operations with rollback capability
   - Proper exception handling

2. **Operations Module** (`/opt/webstack/lib/ktp_ops.py`)
   - SnapshotManager class (replace snapshot_webstack.sh)
   - PushoverNotifier class (replace notify_pushover.sh)
   - FailureHandler class (replace failure.sh)
   - All operations logged to database

3. **Database Schema**
   ```sql
   CREATE TABLE version_history (
     id INT AUTO_INCREMENT PRIMARY KEY,
     version VARCHAR(20),
     timestamp DATETIME,
     snapshot_path VARCHAR(255),
     git_commit VARCHAR(40),
     changes TEXT,
     status ENUM('success', 'failed', 'rolled_back')
   );
   
   CREATE TABLE operation_logs (
     id INT AUTO_INCREMENT PRIMARY KEY,
     timestamp DATETIME,
     operation VARCHAR(100),
     status VARCHAR(20),
     details TEXT,
     error_message TEXT
   );
   ```

### Benefits Over Shell Scripts
- Testable with unit tests
- Proper error handling (not just exit codes)
- Database audit trail (not just text files)
- Rollback capabilities
- No more VERSION file corruption bugs

---

*This roadmap is a living document and will be updated as priorities shift and new opportunities emerge.*