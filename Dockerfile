FROM php:8.2-cli

# Install dependensi sistem
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev

# Install edkstensi PHP yang dibutuhkan Laravel
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Ambil Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Atur folder kerja
WORKDIR /app
COPY . .

# Install dependensi Laravel
RUN composer install --no-dev --optimize-autoloader

# Berikan hak akses folder storage dan cache
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# Kunci port internal container ke port 80
EXPOSE 80

# Jalankan migrasi dan nyalakan server langsung di port 80
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=80