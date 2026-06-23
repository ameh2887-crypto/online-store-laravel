# 1. Ganti ke versi CLI agar bisa menjalankan artisan serve dengan mulus
FROM php:8.2-cli

# 2. Install dependensi sistem
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev

# 3. Install ekstensi PHP yang dibutuhkan Laravel
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# 4. Ambil Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Atur folder kerja
WORKDIR /app
COPY . .

# 6. Install dependensi laravel
RUN composer install --no-dev --optimize-autoloader

# 7. Berikan hak akses folder storage
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# 8. Biarkan Railway mendeteksi PORT secara dinamis
EXPOSE 8080

# 9. Perintah start yang benar menggunakan variabel $PORT tanpa kurung kurawal bermasalah
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT