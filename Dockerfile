FROM php:8.2-cli



RUN apt-get update && apt-get install -y \

    git unzip curl libzip-dev libpng-dev libonig-dev \

    && docker-php-ext-install pdo_mysql zip mbstring \

    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \

    && apt-get clean && rm -rf /var/lib/apt/lists/*



WORKDIR /app



COPY composer.json composer.lock ./

RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts



COPY . .

RUN composer dump-autoload --optimize



RUN mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache \

    && chmod -R 775 storage bootstrap/cache



COPY docker/entrypoint.sh /entrypoint.sh

RUN chmod +x /entrypoint.sh



EXPOSE 10000



ENTRYPOINT ["/entrypoint.sh"]


