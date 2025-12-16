FROM php:7.3-fpm-alpine3.11

ADD repositories /etc/apk/repositories

RUN apk update && \
    apk add --no-cache nginx libmagic && \
    docker-php-ext-install fileinfo && \
    mkdir -p /run/nginx && \
    rm -rf /var/cache/apk/*

COPY default.conf /etc/nginx/conf.d/default.conf
COPY init.sh /init.sh
RUN chmod +x /init.sh

WORKDIR /var/www/html
COPY ./src /var/www/html/

RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 555 /var/www/html

EXPOSE 80

ENTRYPOINT ["/init.sh"]