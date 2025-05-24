#!/bin/bash
echo "USER: $(whoami)"
echo "HOME: $HOME"
echo "PWD: $(pwd)"
echo "GIT VERSION:"
git --version
echo
echo "Listing Git config:"
git config --list
echo
echo "Trying: git rev-list"
git rev-list --count --all --since="24 hours ago"
echo
echo "Trying: git log"
git log --since="24 hours ago" --pretty=format:'%s'

