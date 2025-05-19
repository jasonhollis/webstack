#!/usr/bin/env python3
from http.server import BaseHTTPRequestHandler, HTTPServer
import subprocess
from datetime import datetime

PORT = 9000
LOG_FILE = "/opt/webstack/logs/webhook.log"
DEPLOY_SCRIPT = "/opt/webstack/bin/deploy.sh"

class WebhookHandler(BaseHTTPRequestHandler):
    def do_POST(self):
        length = int(self.headers.get('Content-Length', 0))
        _ = self.rfile.read(length)  # consume payload

        with open(LOG_FILE, "a") as f:
            f.write(f"[{datetime.now()}] Webhook received from {self.client_address[0]}\n")

        try:
            subprocess.Popen([DEPLOY_SCRIPT])
            self.send_response(200)
            self.end_headers()
            self.wfile.write(b"Deploy triggered\n")
        except Exception as e:
            with open(LOG_FILE, "a") as f:
                f.write(f"[{datetime.now()}] Error: {e}\n")
            self.send_response(500)
            self.end_headers()
            self.wfile.write(b"Deploy failed\n")

if __name__ == "__main__":
    with HTTPServer(("", PORT), WebhookHandler) as httpd:
        with open(LOG_FILE, "a") as f:
            f.write(f"[{datetime.now()}] Starting webhook listener on port {PORT}\n")
        httpd.serve_forever()
