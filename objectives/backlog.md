# Backlog – KTP Webstack (as of v1.5.8-dev-backlog)

## Meta Tag Hygiene
- [ ] Ensure every public-facing page (especially index.php and smallbiz.php) has a unique and accurate meta description and title, visible in live HTML.
- [x] Implement live HTML-based SEO/meta checker in system_meta.php.

## System Meta Improvements
- [ ] Make memory output in System Meta Overview human-readable (show “total”, “used”, “free” clearly).
- [ ] Refine SSL/TLS section: If no certificate is found, show a clear explanation (file path/permissions), not just “No SSL certificate found”.
- [ ] Add cert expiry date in a prominent format if possible.

## Backlog Management
- [ ] Build a /admin/backlog.php (or markdown-driven backlog page) to track, categorize, and tick off recurring pain points, TODOs, and “mental clutter”.

## Quality-of-Life
- [ ] Regularly review the admin dashboard and meta tag table for regressions after any deploy.
- [ ] Optionally, auto-scan all PHP files in the public directory to keep the $public_pages list up to date.

---
