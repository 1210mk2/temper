FROM php:7.4-fpm-alpine

# Install tools required for build stage
RUN apk add --update --no-cache \
    bash curl wget git tzdata autoconf \
    g++ gcc gnupg libgcc make

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
 && chmod 755 /usr/bin/composer

# Install additional PHP libraries
RUN docker-php-ext-install bcmath pdo_mysql

# Install xdebug
RUN pecl install xdebug \
 && docker-php-ext-enable xdebug

# Enable XDebug
#ADD /docker/config/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
ADD /docker/config/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
ADD /docker/config/php.ini /usr/local/etc/php/php.ini
#RUN echo xdebug.remote_enable=1 >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo xdebug.remote_port=9000 >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo xdebug.remote_autostart=1 >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo xdebug.remote_connect_back=0 >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo xdebug.idekey=PHP_STORM >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo xdebug.remote_host=172.19.0.1 >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

WORKDIR /var/www/rd-docker