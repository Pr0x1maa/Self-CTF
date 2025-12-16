#!/bin/bash

echo $GZCTF_FLAG > /flag
export GZCTF_FLAG="not_flag" 
GZCTF_FLAG="not_there_flag"

# 启动 PHP-FPM (后台运行)
php-fpm -D

# 启动 Nginx (前台运行，保持容器存活)
nginx -g "daemon off;"