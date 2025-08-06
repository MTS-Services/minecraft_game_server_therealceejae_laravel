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
    && docker-php-ext-install pdo pdo_mysql mysqli bcmath zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js and NPM for asset compilation
RUN apk add --no-cache nodejs npm

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

WORKDIR /var/www/azuriom

COPY --chown=www-data:www-data . /var/www/azuriom/


# Copy required files first (composer.json, package.json, etc.)
# COPY --chown=www-data:www-data composer.* ./
# COPY --chown=www-data:www-data package.* ./
# COPY --chown=www-data:www-data webpack.mix.js ./

# Install PHP and Node dependencies
RUN composer install --no-dev --optimize-autoloader
RUN npm install

# Copy the rest of the application code
COPY --chown=www-data:www-data . /var/www/azuriom/

# Run Laravel Mix to compile assets inside the container
RUN npm run production


USER www-data

EXPOSE 9000

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

CMD ["php-fpm"]
