FROM php:8.2-fpm AS php_fpm

LABEL MAINTAINER Alexandre ANDRE <a.andre@prohacktive.io>

# Install dependencies
RUN apt-get update && \
    apt-get install -y \
    libicu-dev \
    libssl-dev git \
    gnupg gnupg1 gnupg2 \
    libzip-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libgmp-dev -y


# Install PHP extensions
RUN docker-php-ext-install pdo \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install intl \
    && docker-php-ext-install zip \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-configure gmp \
    && docker-php-ext-install gmp

# Config PHP
COPY ./_config/php.ini /usr/local/etc/php/

# Install xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Install pcov
RUN pecl install pcov && docker-php-ext-enable pcov

# Install PHPUnit
RUN curl -OL https://phar.phpunit.de/phpunit.phar \
    && chmod 755 phpunit.phar \
    && mv phpunit.phar /usr/local/bin/ \
    && ln -s /usr/local/bin/phpunit.phar /usr/local/bin/phpunit

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Paris /etc/localtime
RUN "date"

# change the “UID” number to www-data:
RUN usermod -u 1000 www-data

# Clean
RUN apt-get clean
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /var/cache/*

## Create log dir with right permission
RUN mkdir -p /var/log/prohacktive
RUN chown -R 1000:www-data /var/log/prohacktive

# Set default workdir
WORKDIR /var/www

# Install Composer
COPY --chown=www-data:www-data --from=composer:latest /usr/bin/composer /usr/bin/composer

CMD ["php-fpm"]


