#!/bin/sh

echo $GZCTF_FLAG > /flag

export GZCTF_FLAG="not_flag" 
GZCTF_FLAG="Th1s_1s_n0t_wh2t_yo3_w4nt"

php-fpm -D
nginx -g 'daemon off;'