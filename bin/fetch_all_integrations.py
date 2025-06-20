#!/usr/bin/env python3
import json
import requests
from bs4 import BeautifulSoup
from pathlib import Path

OUTPUT_JSON = Path("/opt/webstack/html/data/all_integrations_raw.json")
DUMP_HTML = Path("/opt/webstack/html/data/integrations_index_dump.html")

# Download HTML and save for debug
resp = requests.get("https://www.home-assistant.io/integrations/", timeout=15)
resp.raise_for_status()
with open(DUMP_HTML, "w", encoding="utf-8") as f:
    f.write(resp.text)

soup = BeautifulSoup(resp.text, "html.parser")
anchors = soup.find_all("a")

results = []
for a in anchors:
    href = a.get("href", "")
    if not href.startswith("/integrations/") or "integration" not in href:
        continue
    slug = href.strip("/").split("/")[-1]
    label = a.get_text(strip=True)[:60]  # Short text label
    img = a.find("img")
    logo = img["src"] if img and "src" in img.attrs else None
    results.append({
        "slug": slug,
        "name": label,
        "logo": logo,
        "url": f"https://www.home-assistant.io{href}"
    })

with open(OUTPUT_JSON, "w", encoding="utf-8") as out:
    json.dump(results, out, indent=2)

print(f"✅ Found {len(results)} entries. JSON → {OUTPUT_JSON}")
print(f"📄 Dumped HTML to → {DUMP_HTML}")
