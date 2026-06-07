FROM php:8.2-cli

# Sistem bağımlılıklarını ve PostgreSQL için gerekli kütüphaneleri (libpq-dev) kuruyoruz
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql pgsql zip gd mbstring

# Composer'ı resmi imajdan kopyalıyoruz
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Proje dosyalarını container içine aktarıyoruz
WORKDIR /var/www
COPY . .

# Bağımlılıkları yüklüyoruz
RUN composer install --no-dev --optimize-autoloader

# Render'ın dinlediği varsayılan portu tanımlıyoruz
EXPOSE 10000

# Projeyi başlatma komutu (Veritabanını güncelleyip başlatır)
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000