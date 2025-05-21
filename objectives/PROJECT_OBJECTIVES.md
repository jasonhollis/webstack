# PROJECT_OBJECTIVES.md

## KTP Website: Project Objectives

This project delivers a secure, modern web presence for KTP Digital, built for easy management, analytics, and continual improvement.

### Core Goals:
- Provide a simple, maintainable, and secure PHP/Tailwind website
- Support rapid deployment and rollback using ZIP snapshots and Git
- Centralize all administration and analytics under `/admin`
- Log and visualize site usage for ongoing market segmentation and SEO optimization
- Ensure that objectives and change history are always visible and versioned
- Enable seamless future migration from `ww2.ktp.digital` to `www.ktp.digital` with no hardcoded subdomain logic
- Keep all navigation and assets relative or config-driven for environment portability

### Admin/Analytics Roadmap:
- Admin hub at `/admin/`
- Download any snapshot or log file from the admin panel
- Track pageviews, user agents, referers, and IPs for traffic analysis
- Show version and objectives history in a human-readable form
- Allow secure access (username+password, then later OIDC or SSO)
- Future: Expose key site settings and SEO controls to admin panel

---
### Remote Workflow Support:
- All project management, file editing, and admin must be fully operable via SSH and SCP from a Mac (or other remote system)
- No required steps may assume local desktop GUI access; everything must be executable from a remote shell/editor (vim/nano) or via secure file copy
- All code, admin tools, and setup steps must support headless remote operation (no manual web uploads or GUI installers)
