FROM php:7.3-fpm-alpine

RUN apk update && apk upgrade \
    && apk add --no-cache \
            wget \
            vim \
            git \
            tzdata && \
            cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime && \
            apk del tzdata && \
            rm -rf /var/cache/apk/*

## composer のインストール
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer 
WORKDIR /var/www
ADD ./laravel /var/www
COPY ./env-template/php.ini /usr/local/etc/php/php.ini
# composer install を root ユーザでも行うため。
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_NO_INTERACTION 1
RUN composer install -d /var/www
