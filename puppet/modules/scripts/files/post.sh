#!/usr/bin/env bash

mysql -u root -e "GRANT ALL ON *.* to 'dev'@'%' identified by 'ved';FLUSH PRIVILEGES;CREATE DATABASE keinewaste;"
touch /var/log/keinewaste.log && chmod 0777 /var/log/keinewaste.log