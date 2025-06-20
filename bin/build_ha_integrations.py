import json
import requests
from bs4 import BeautifulSoup
from pathlib import Path

# Paths
ROOT = Path("/opt/webstack/html")
INPUT_FILE = ROOT / "data/integrations.json"
ALIAS_FILE = ROOT / "data/domain_aliases.json"
OUTPUT_FILE = ROOT / "data/ha_integrations.json"

# Load domain → label list
with open(INPUT_FILE, "r", encoding="utf-8") as f:
    domains = {item["domain"]: item["label"] for item in json.load(f)}

# Load alias overrides
aliases = {}
if ALIAS_FILE.exists():
    with open(ALIAS_FILE, "r", encoding="utf-8") as f:
        aliases = json.load(f)

# Build slug → domain map
slugs = {}
for domain, label in domains.items():
    if domain in aliases and aliases[domain] is None:
        continue  # explicitly excluded
    slug = aliases.get(domain, domain)
    slugs[slug.lower()] = {"domain": domain, "label": label}

print("Expected slugs from JSON:", sorted(slugs.keys()))

# Fetch integrations index
resp = requests.get("https://www.home-assistant.io/integrations/", timeout=10)
resp.raise_for_status()
soup = BeautifulSoup(resp.text, "html.parser")
cards = soup.select("a.block.space-y-2")

found = []
skipped = []

for a in cards:
    href = a.get("href", "")
    if not href.startswith("/integrations/"):
        continue
    slug = href.strip("/").split("/")[-1].lower()
    print(f"Found slug in page: {slug}")
    if slug not in slugs:
        print(f"❌ Skipped (no match): {slug}")
        skipped.append(slug)
        continue
    icon = a.find("img")
    logo = icon["src"] if icon and "src" in icon.attrs else "/images/brand/generic.svg"
    item = slugs[slug]
    found.append({
        "domain": item["domain"],
        "name": item["label"],
        "url": f"https://www.home-assistant.io{href}",
        "logo": logo
    })

with open(OUTPUT_FILE, "w", encoding="utf-8") as out:
    json.dump(found, out, indent=2)

print(f"\n✅ Wrote {len(found)} entries to {OUTPUT_FILE}")
if skipped:
    print(f"🚫 Skipped {len(skipped)} unmatched slugs:")
    for s in sorted(skipped):
        print("  -", s)
