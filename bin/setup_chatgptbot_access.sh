#!/bin/bash
# Setup script for chatgptbot automation user environment on Debian

USER=chatgptbot
SSH_DIR="/home/$USER/.ssh"
AUTHORIZED_KEYS="$SSH_DIR/authorized_keys"

echo "Creating user $USER if it does not exist..."
if ! id "$USER" &>/dev/null; then
  adduser --disabled-password --gecos "ChatGPT Bot" "$USER"
else
  echo "User $USER already exists."
fi

echo "Ensuring .ssh directory exists with correct permissions..."
mkdir -p "$SSH_DIR"
chmod 700 "$SSH_DIR"
chown "$USER:$USER" "$SSH_DIR"

echo "Waiting for you to place the public SSH key into $AUTHORIZED_KEYS"
echo "Once the key is added, set permissions as follows:"
echo "  chmod 600 $AUTHORIZED_KEYS"
echo "  chown $USER:$USER $AUTHORIZED_KEYS"
echo "You can add the key manually or via:"
echo "  cat your_public_key.pub | sudo tee $AUTHORIZED_KEYS"

echo "This script sets up the user and SSH environment but expects the public key to be added separately."

