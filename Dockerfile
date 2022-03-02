FROM wordpress:latest
LABEL maintainer Nuriel Meni <nurielmeni@gmail.com>

RUN apt-get update && apt-get install -y libxml2 libxml2-dev

# Install PHP Soap Extention
RUN docker-php-ext-install soap

# Install Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug --ini-name 10-docker-php-ext-xdebug.ini

COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

#INSTALL APCU
RUN pecl install apcu-5.1.21 && docker-php-ext-enable apcu
RUN echo "extension=apcu.so" > /usr/local/etc/php/php.ini
RUN echo "apc.enable_cli=1" > /usr/local/etc/php/php.ini
RUN echo "apc.enable=1" > /usr/local/etc/php/php.ini
#APCU