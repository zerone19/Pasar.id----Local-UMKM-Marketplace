FROM php:8.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libicu-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy Laravel application source into working directory
COPY ./pasar-id/ .

# Copy entrypoint script and make it executable
COPY ./pasar-id/entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Create non-root user
RUN useradd -m -G www-data -u 1000 laravel && \
    mkdir -p /home/laravel/.composer && \
    chown -R laravel:laravel /home/laravel && \
    chown -R www-data:www-data /var/www/html

# Dev-only: make writable dirs world-writable so php-fpm (www-data) can write
# compiled views/cache even though the mounted volume is owned by the host user.
RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000

# Set entrypoint to ensure dependencies are installed on container start
ENTRYPOINT ["docker-entrypoint.sh"]
