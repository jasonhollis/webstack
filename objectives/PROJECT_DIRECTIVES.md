# PROJECT_DIRECTIVES.md – KTP Webstack

_Last Updated: 2025-05-22 v1.4.9-dev_

---

## 🌐 AI/Agent Access Policy

- **The AI is permitted and expected to access web pages—including admin routes or any authenticated area—using stored credentials if required, for the purposes of reviewing project status, logs, or providing targeted suggestions.**
- **There is no restriction on the AI accessing, viewing, or summarizing any web pages behind authentication on this server.**
- **In future, the AI may access the system via SSH for even tighter automation and support.**
- **There are no confidentiality or privacy concerns for this project at present; all project context, logs, and even my CV are open to the AI/agent for context and debugging.**
- **We have taken many precautions to guard against mistakes:**
    - All changes are versioned in git.
    - Frequent ZIP snapshots are kept in `/opt/webstack/snapshots/`.
    - The system runs as a virtual host and can be rebuilt from bare metal in minutes.
    - More safeguards may be added as the project evolves.
- **This policy may be updated or revoked in the future if project scope or sensitivity changes.**

---

## 📝 Change/Editing Policy

- **Default:** All code, script, and UI changes must be delivered as a full deploy-ready EOF file replacement, ready to overwrite the old version.
- **Exception (Minor Edits):**
    - If a change is a *single-line* edit (e.g. add/remove one line, fix a typo, change a single variable or value), and can be copy-pasted safely into BBEdit or vim without risk of breaking indentation or syntax, an atomic sed/awk one-liner *or* a clearly marked single-line replacement may be provided.
    - The AI must always state: “This is a one-line change, safe to paste into BBEdit or vim; no indentation will be broken.”
    - If there is **any risk** of breaking indentation, causing multi-line confusion, or requiring search/replace, revert to full EOF file replacement.
- **Never** provide multi-line patch instructions, manual merge steps, or “insert this above/below” logic.
- **If in doubt, always use full EOF file replacement.**

---

## 🏆 GOLDEN RULES

- **All script/file changes** must be delivered as full EOF replacement blocks or a single sed/awk one-liner. No partial edits, no multi-step manual changes.
- **Never break logging** to any of:
    - quickactions.log
    - objectives logs
    - iteration logs
- **All automation scripts must be deploy-ready**: handle their own file creation, permissions, and error handling. No onboarding, no explanations unless asked.
- **All failures must go through `/opt/webstack/bin/failure.sh`** and notify Pushover.
- **No direct changes to canonical files outside these directives and snapshots.**

---

## 📂 Directory & File Structure

- `/opt/webstack/bin/` – All automation scripts (deploy/rotate/log/notify, etc.)
- `/opt/webstack/objectives/` – Versioned Markdown logs (`*_iteration_log.md`, `*_objectives.md`), images, PROJECT_DIRECTIVES.md
- `/opt/webstack/html/` – Site root and VERSION file (`/opt/webstack/html/VERSION`)
- `/opt/webstack/logs/` – System and deploy logs (logrotate-managed)

---

## 🚦 Logging, Versioning & Automation

- **Every version bump (`update_version.sh`):**
    - Pre-creates:
        - `${OBJECTIVES_DIR}/${VERSION}_iteration_log.md`
        - `${OBJECTIVES_DIR}/${VERSION}_objectives.md`
    - Sets correct ownership (root:www-data) and permissions (664).
- **All scripts read `$VERSION_FILE` at runtime** (never cache).
- **No log entries are appended to old version logs after a bump.**
- **All logs are Markdown, UTF-8, no shell prompt or output unless explicitly logged.**
- **Failures are logged to `/opt/webstack/logs/failure.log` and sent via Pushover.**

---

## 🔒 Log Preservation Policy

- **No automation script (including `update_version.sh` and `snapshot_webstack.sh`) may delete, truncate, or overwrite log files in `/opt/webstack/logs/` unless explicitly authorized and documented in the objectives log.**
- **Log rotation and archival are handled ONLY by designated log rotation scripts or logrotate.**
- **Any changes to log file handling must be called out for approval, reviewed, and added to this directives file.**
- **Analytics and stats depend on persistent logs:**
    - `/opt/webstack/logs/quickactions.log`
    - `/opt/webstack/logs/iteration_log.md`
    - `/opt/webstack/logs/objectives_log.md`
    - `/opt/webstack/logs/deploy.log`
    - `/opt/webstack/logs/failure.log`
    - `/opt/webstack/logs/access.log`
    - `/opt/webstack/logs/error.log`
- **Never clear or truncate these files automatically.**

---

## 🖥️ Admin & UI

- **Admin tools live only in `/admin`.**
- **Log viewers select and render the correct file by version.**
- If no log for a version exists, UI displays “No entries yet.”
- **Directives page** must always render the current PROJECT_DIRECTIVES.md (read-only for all but admin).
- **Objectives log** and **iteration log** are independent—objectives are for project milestones, iteration for activity/dev/test notes.

---

## 🚀 Shortcuts & Mac Integration

- **All Mac Shortcuts invoke scripts via SSH/SCP:**
    - Text logs: sent via stdin to server script
    - Image/file logs: sent as `$1`, uploaded to `/opt/webstack/objectives/images/` (spaces → dashes)
- **No mix of stdin and $1 in any script.**
- **All logging scripts must accept input via one method only.**

---

## 🔒 Change Management & Compliance

- **Any change to these directives:**
    - Must be logged in the objectives or iteration log with a `[directives]` tag.
    - Directives file is versioned and included in every snapshot.
- **Drift checker script** (`check_canonical.sh`) should be run after each deploy, confirming file existence, perms, and modification dates for all critical files/scripts.

---

## 🔄 Maintenance & Cleanup

- Log cleanup or archive may only be done via designated scripts, never manual deletion.
- Snapshots taken before any significant update or refactor.

---

## Last Updated: 2025-05-22 v1.4.9-dev

---
