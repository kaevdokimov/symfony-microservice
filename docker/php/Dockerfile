FROM php:8.4-fpm
RUN apt-get update && apt-get install -y zlib1g-dev g++ git libicu-dev zip libzip-dev libpq-dev zip \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install intl opcache pdo_pgsql pgsql \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip
WORKDIR /var/www/promo-engine
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony
