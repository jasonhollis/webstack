#!/bin/bash

BASE="https://www.ktp.digital"
PAGES=(index.php about.php contact.php automation.php enterprise.php smallbiz.php nas.php macos-tools.php methodology.php)

for PAGE in "${PAGES[@]}"; do
  echo -e "\n🔗 $PAGE"
  curl -s -D - -o /dev/null -w "Status: %{http_code} | Time: %{time_total}s\n" "$BASE/$PAGE"
done
