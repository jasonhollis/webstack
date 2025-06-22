Here’s a draft of the release notes for **v1.7.2**:

---

## v1.7.2 – 2025-06-22

**Landing page & icons**

* 🛠 Fixed missing/broken icons for:

  * HomeKit Bridge (now reuses HomeKit Device icon)
  * Porsche Connect
  * Sony Bravia TV
  * Zigbee2MQTT
* ➕ Added new integration icons:

  * Amazon Alexa
  * IKEA TRÅDFRI
  * Shelly
  * SmartThings
* 🚮 Stripped out the debug `var_dump` from `landing.php`
* 🔤 Ensured the integration grid is sorted alphabetically

**Icon-fetch scripts**

* 🐛 Tightened up `fetch_ha_icons.sh` and `fetch_extra_icons.sh`:

  * Correct JSON path detection
  * Unified use of `failure.sh` for error alerts
  * Cleaner slug overrides and fallback logic
  * Consolidated into one-copy-and-paste BBEdit-ready shell snippets
* 🗓 Brought cron entries back to production schedule and cleaned up test logs

**Deployment tooling**

* 🔄 **update\_version.sh** now takes a snapshot of the **old** version *before* bumping, so your backups always reflect what you’re replacing
* ✅ All existing snapshot and logging behavior preserved

---

Let me know if you’d like any tweaks before you run the version bump!
