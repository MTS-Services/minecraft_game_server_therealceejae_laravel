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

# # Install Composer
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# # Install Node.js and NPM for asset compilation
# RUN apk add --no-cache nodejs npm

# ----------------------------------------
# 2. Install Node.js & npm
# ----------------------------------------
# RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
#     && apt-get install -y nodejs

# ----------------------------------------
# 3. Install Composer
# ----------------------------------------
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

WORKDIR /var/www/azuriom

# ----------------------------------------
# 5. Copy Laravel app source
# ----------------------------------------
COPY . .

# ----------------------------------------
# 6. Prepare Laravel cache paths & permissions
RUN mkdir -p storage/framework/{views,sessions,cache} \
    && mkdir -p bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# ----------------------------------------
# 7. Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# ----------------------------------------
# 8. Build frontend (if needed)
RUN if [ -f package.json ]; then npm install && npm run production; fi

# ----------------------------------------
# 9. Laravel Artisan commands
RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan migrate --force || true \
    && php artisan optimize:clear

# COPY --chown=www-data:www-data . /var/www/azuriom/


# Copy required files first (composer.json, package.json, etc.)
# COPY --chown=www-data:www-data composer.* ./
# COPY --chown=www-data:www-data package.* ./
# COPY --chown=www-data:www-data webpack.mix.js ./

# # Install PHP and Node dependencies
# RUN composer install --no-dev --optimize-autoloader
# RUN npm install

# # Copy the rest of the application code
# COPY --chown=www-data:www-data . /var/www/azuriom/

# # Run Laravel Mix to compile assets inside the container
# RUN npm run production


USER www-data

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

CMD ["php-fpm"]
