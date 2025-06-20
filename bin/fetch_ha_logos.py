#!/opt/webstack/venv/bin/python3
import os
import aiohttp
import asyncio
import json

OUTPUT_DIR = "/opt/webstack/html/images/icons"
JSON_SOURCE = "/opt/webstack/html/data/ha_integrations.json"

async def download_logo(session, domain):
    url = f"https://www.home-assistant.io/images/integrations/{domain}/icon.png"
    out_path = os.path.join(OUTPUT_DIR, f"{domain}.png")
    try:
        async with session.get(url) as response:
            if response.status == 200:
                with open(out_path, 'wb') as f:
                    f.write(await response.read())
                print(f"✅ {domain}")
            else:
                print(f"❌ {domain}: HTTP {response.status}")
    except Exception as e:
        print(f"⚠️  {domain}: {e}")

async def main():
    with open(JSON_SOURCE, 'r') as f:
        data = json.load(f)
    domains = [entry["domain"] for entry in data if "domain" in entry]
    async with aiohttp.ClientSession() as session:
        tasks = [download_logo(session, domain) for domain in domains]
        await asyncio.gather(*tasks)

if __name__ == "__main__":
    asyncio.run(main())
