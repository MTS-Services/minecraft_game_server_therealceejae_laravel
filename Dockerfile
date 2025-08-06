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

# Switch to the www-data user to run commands that need write permissions
USER www-data

# Now run composer and npm commands as www-data
RUN composer install --no-dev --optimize-autoloader
RUN npm install
RUN npm run production

# Prepare Laravel cache paths and permissions
RUN mkdir -p storage/framework/{views,sessions,cache} \
    && mkdir -p bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Switch back to root for any other commands that might need it
USER root

# Copy and set up the entrypoint script
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Final user and command setup
USER www-data
EXPOSE 9000
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]