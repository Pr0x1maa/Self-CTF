FROM php:7.3-fpm-alpine3.11 AS builder

ADD repositories /etc/apk/repositories

RUN apk update && \
    apk add --no-cache m4 autoconf make gcc g++ linux-headers 

RUN docker-php-ext-install pdo_mysql opcache mysqli 

FROM php:7.3-fpm-alpine3.11

ADD repositories /etc/apk/repositories

RUN apk update && \
    apk add --no-cache nginx && \
    mkdir /run/nginx && \
    touch /run/nginx/nginx.pid && \
    rm -rf /var/cache/apk/*

COPY --from=builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

COPY default.conf /etc/nginx/conf.d/default.conf
COPY init.sh /init.sh
RUN chmod 755 /init.sh

COPY ./src /var/www/html/
RUN chmod 755 /var/www/html/

EXPOSE 80
EXPOSE 9000

ENTRYPOINT ["/init.sh"]