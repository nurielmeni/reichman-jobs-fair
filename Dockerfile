FROM wordpress:latest
LABEL maintainer Nuriel Meni <nurielmeni@gmail.com>

RUN apt-get update && apt-get install -y libxml2 libxml2-dev

# Install PHP Soap Extention
RUN docker-php-ext-install soap

# Install Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug --ini-name 10-docker-php-ext-xdebug.ini

COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
