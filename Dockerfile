ARG PHP_VERSION=7.4
FROM php:${PHP_VERSION}-fpm-alpine
LABEL maintainer="Giovane Santos <giovanesantos1999@gmail.com>"

RUN apk update && apk add  \
    libzip-dev \
    make \
    nginx \
    bash

RUN docker-php-ext-install pdo && \
    docker-php-ext-install pdo_mysql && \
    docker-php-ext-install zip && \
    docker-php-ext-install json

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer

RUN rm -f /etc/nginx/conf.d/default.conf /etc/nginx/nginx.conf
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/
COPY ./docker/nginx/nginx.conf /etc/nginx/

EXPOSE 80

WORKDIR /var/www/html
RUN chown -R www-data:www-data /var/www/html
RUN chown -R www-data:www-data /var/lib/nginx

COPY ./docker/entrypoint.sh /etc/entrypoint.sh
RUN chmod +x /etc/entrypoint.sh

RUN rm -rf /var/cache/apk/*

ENTRYPOINT [ "/etc/entrypoint.sh" ]
