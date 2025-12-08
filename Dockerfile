FROM php:8.2-fpm-alpine

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

RUN apk add icu-dev
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-configure intl && docker-php-ext-install intl

RUN apk add --no-cache \
      libzip-dev \
      zip \
    && docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

# Copy only composer files first for caching
COPY composer.json composer.lock ./

RUN chmod -R 0755 ./ 

# Install dependencies (production)
RUN composer install  --optimize-autoloader --no-dev --no-scripts --no-plugins --ignore-platform-reqs

#COPY . .
COPY --chown=www-data:www-data . .

USER www-data

EXPOSE 9000
