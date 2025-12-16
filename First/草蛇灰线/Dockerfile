FROM leleos/php-fpm:5.4

RUN echo "deb http://mirrors.aliyun.com/debian-archive/debian/ jessie main non-free contrib" > /etc/apt/sources.list \
    && echo "deb http://mirrors.aliyun.com/debian-archive/debian-security/ jessie/updates main non-free contrib" >> /etc/apt/sources.list \
    && echo 'Acquire::Check-Valid-Until "false";' > /etc/apt/apt.conf.d/99no-check-valid-until

ADD default.conf /etc/nginx/conf.d/default.conf
ADD init.sh /
ADD ./src/ /var/www/html

RUN echo "Pr0_don't_W@nt_y2u_to_u3e_th1s" > /password \
    && chmod 644 /password

RUN touch /flag \
    && chmod 666 /flag

RUN apt-get update -o Acquire::http::Timeout=60 || true \
    && apt-get install -y --force-yes nginx \
    && rm -rf /etc/nginx/sites-enabled/default \
    && docker-php-ext-install mysqli pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

RUN mkdir -p /run/nginx \
    && chmod +x /init.sh \
    && chown -R www-data:www-data /var/www/html

EXPOSE 80
EXPOSE 9000

ENTRYPOINT ["/init.sh"]