# 🚀 KTP Webstack Roadmap – Brainstorm & Options

## In Progress / Current Objectives
- Polish `/admin/analytics.php` (UI, top IPs, IP exclude toggle, sparkline/day graph, mobile display).
- Document public roadmap and update methodology for collaborative development.

---

## Admin Panel Improvements
- [ ] Add 2FA or TOTP-based authentication for `/admin` (beyond password hash).
- [ ] Global search for all logs, objectives, and version notes in admin.
- [ ] Refactor all admin tools for 100% dark mode, mobile, and accessibility.
- [ ] Merge Objectives and Iteration Logs into a unified view (with filters).
- [ ] Add inline markdown editor for objectives/roadmap (edit in browser).
- [ ] Add “quick links” or admin dashboard summary for key health, uptime, and last errors.
- [ ] Auto-expiry and cleanup controls for snapshots and logs (UI-driven).
- [ ] Implement role-based admin (add more users, permissions, audit log).
- [ ] Add UI to restore from snapshot or backup (one-click recovery).
- [ ] **UI-driven Roadmap Management:** Select/tick items from roadmap/backlog in the admin UI and click “Go” to move them into the current release or “In Progress.” (Future: drag-and-drop between Backlog, In Progress, Completed.)

---

## Monitoring & Automation
- [ ] Public status/uptime page with real-time heartbeat from server.
- [ ] Automated Pushover alerts for key failures (extend `/bin/failure.sh` logic to more subsystems).
- [ ] Automated site health check (page load, SSL, DNS, storage space).
- [ ] Cron job maintenance UI for scheduled cleanups, backups, certs, etc.

---

## Content & SEO
- [ ] Rewrite main pages for maximum clarity, SEO, and “why KTP?” storytelling.
- [ ] Add `/macos-tools.php` and `/automation.php` case studies for Home Assistant and real client work.
- [ ] Expand documentation for workflows (how/when to use git vs. file backups).
- [ ] Generate and display OpenGraph/Twitter card previews for all major pages.
- [ ] Add sitemap.xml and robots.txt generator in admin.

---

## Development & DevOps
- [ ] Add one-click download/export of any version or snapshot.
- [ ] Bash scripts to automate rollback/restore from any snapshot (even partial restore).
- [ ] Option to run selective test suite after every commit (PHP lint, HTML check, broken links, permissions).
- [ ] Integrate external log shipping (optionally send logs to S3 or remote syslog).
- [ ] Option to mirror repo to GitHub Actions or self-hosted CI for smoke tests.

---

## Quality of Life / Power Tools
- [ ] File browser for `/opt/webstack/logs`, `/snapshots`, and `/objectives` (view, download, delete).
- [ ]
