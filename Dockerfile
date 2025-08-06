FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    git \
    curl \
    zip \
    unzip \
    libzip-dev \
    mysql-client \
    mysql-dev \
    openssl \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_mysql mysqli bcmath zip

# Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Copy the entire application code into the container
WORKDIR /var/www/azuriom
COPY --chown=www-data:www-data . /var/www/azuriom/

# Run Composer and NPM commands inside the container
RUN composer install --no-dev --optimize-autoloader

# FIX: Add this line to ensure the vendor directory is owned by www-data
RUN chown -R www-data:www-data vendor/

RUN npm install
RUN npm run production

# Prepare Laravel cache paths and permissions
RUN mkdir -p storage/framework/{views,sessions,cache} \
    && mkdir -p bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Copy and set up the entrypoint script
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

USER www-data

EXPOSE 9000

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

CMD ["php-fpm"]