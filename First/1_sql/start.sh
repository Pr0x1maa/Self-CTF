#!/bin/bash

service mariadb start

sleep 5

mysql < /app/schema.sql

mysql -e "CREATE USER 'Pr0x1ma'@'localhost' IDENTIFIED BY 'Th1s_1s_p233_wo2d';"
mysql -e "GRANT SELECT, INSERT ON Terra_User.* TO 'Pr0x1ma'@'localhost';"
mysql -e "GRANT SELECT ON Terra_Data.* TO 'Pr0x1ma'@'localhost';"
mysql -e "FLUSH PRIVILEGES;"

FLAG_VALUE=${GZCTF_FLAG:-"Pr0{T2s7_F12g}"}

mysql -e "USE Terra_Data;INSERT INTO secret (id, value, flag) VALUES (0, 'FLAG', '$FLAG_VALUE');"

python3 /app/app.py