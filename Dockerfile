# Gunakan image PHP resmi dengan konfigurasi FPM dan versi yang sesuai
FROM php:8.2-fpm

# Instal dependensi sistem dan ekstensi PHP yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Eksekusi pemasangan driver database MySQL secara paksa di server
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Ambil Composer versi terbaru
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Atur folder kerja di dalam container server
WORKDIR /app
COPY . .

# Jalankan instalasi composer untuk vendor packagemu
RUN composer install --no-dev --optimize-autoloader

# Berikan hak akses untuk folder storage Laravel
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# Port default yang dibuka oleh Railway
EXPOSE 80

# Jalankan aplikasi dan jalankan migrasi database saat start
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-80}