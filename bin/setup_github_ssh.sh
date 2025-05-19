#!/bin/bash

EMAIL="jason@jasonhollis.com"
KEY_PATH="/root/.ssh/id_github"

echo "🔐 Generating SSH key for GitHub as $EMAIL..."
ssh-keygen -t ed25519 -C "$EMAIL" -f "$KEY_PATH" -N ""

echo "📋 Public key:"
cat "${KEY_PATH}.pub"

echo "🧭 Now go to https://github.com/settings/keys and add the above as a new SSH key."
