#!/bin/sh

echo $GZCTF_FLAG > /fllllllll1444444ggggg
export GZCTF_FLAG="not_flag" 
GZCTF_FLAG="Th1s_1s_n0t_wh2t_yo3_w4nt"

# 启动 php-fpm，后台运行
php-fpm -D
# 启动 nginx，不要在后台运行，以保持容器活跃
nginx -g 'daemon off;'