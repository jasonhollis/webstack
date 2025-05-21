#!/usr/bin/env python3
from http.server import BaseHTTPRequestHandler, HTTPServer
import json, os, datetime

LOG_DIR = "/opt/webstack/logs"
os.makedirs(LOG_DIR, exist_ok=True)

class WebhookHandler(BaseHTTPRequestHandler):
    def do_POST(self):
        length = int(self.headers.get('Content-Length', 0))
        payload = self.rfile.read(length).decode('utf-8')

        # Write to timestamped log file
        timestamp = datetime.datetime.now().strftime("%Y%m%d-%H%M%S")
        log_path = os.path.join(LOG_DIR, f"payload-{timestamp}.json")
        with open(log_path, "w") as f:
            f.write(payload)

        self.send_response(200)
        self.end_headers()
        self.wfile.write(b"Webhook received and logged.\n")

if __name__ == "__main__":
    server_address = ("", 9000)  # Port 9000
    httpd = HTTPServer(server_address, WebhookHandler)
    print("Listening on port 9000...")
    httpd.serve_forever()
