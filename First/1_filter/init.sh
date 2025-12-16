#!/bin/sh

echo "别找了,flag不在这里,快去拿礼物吧:>" > /flag
echo $GZCTF_FLAG > /Th1s_1s_R2a1_flag

export GZCTF_FLAG="Th1s_1s_n0t_wh2t_yo3_w4nt" 
GZCTF_FLAG="Th1s_1s_n0t_wh2t_yo3_w4nt"

php-fpm -D
nginx -g 'daemon off;'