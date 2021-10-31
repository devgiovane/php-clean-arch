ARG PHP_VERSION=7.4
FROM php:${PHP_VERSION}-alpine
LABEL maintainer="Giovane Santos <giovanesantos1999@gmail.com>"
RUN apk update && apk add  \
    bash
RUN docker-php-ext-install pdo && \
    docker-php-ext-install pdo_mysql && \
    docker-php-ext-install json
EXPOSE 80
COPY --from=composer /usr/bin/composer /usr/bin/composer
WORKDIR /usr/src/app
CMD [ "php", "-S", "0.0.0.0:80", "-t", "/usr/src/app/public" ]
