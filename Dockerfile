
# ============================================
# Stage 1: Build frontend assets with Vite
# ============================================
FROM node:22-alpine AS frontend-build

WORKDIR /app

# Install Node.js dependencies
COPY package.json package-lock.json ./
RUN npm ci

# Copy source code and build frontend assets
COPY . .
RUN npm run build


# ============================================
# Stage 2: Run Laravel with Apache and PHP
# ============================================
FROM php:8.5-apache

# Install system dependencies and PHP extensions

# Install system dependencies and PHP extensions
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libicu-dev \
        libzip-dev \
        libxml2-dev \
        libonig-dev \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_mysql \
        mbstring \
        intl \
        zip \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# Set Laravel application directory
WORKDIR /var/www/html

# Copy Laravel source code
COPY . .

# Install production PHP dependencies
RUN composer install \
    --no-dev \
    --prefer-dist \
    --optimize-autoloader \
    --no-interaction \
    --no-progress

# Copy compiled Vite assets from frontend build stage
COPY --from=frontend-build /app/public/build ./public/build

# Configure Apache to serve Laravel's public directory
# Render's configured web service port is 10000
RUN sed -ri \
        's!/var/www/html!/var/www/html/public!g' \
        /etc/apache2/sites-available/000-default.conf \
    && sed -ri \
        's/Listen 80/Listen 10000/' \
        /etc/apache2/ports.conf \
    && sed -ri \
        's/:80>/:10000>/' \
        /etc/apache2/sites-available/000-default.conf \
    && printf '\n<Directory /var/www/html/public>\n    AllowOverride All\n    Require all granted\n</Directory>\n' \
        >> /etc/apache2/apache2.conf

# Create Laravel writable directories and set permissions
RUN mkdir -p \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
    && chown -R www-data:www-data \
        storage \
        bootstrap/cache

# Apache runtime configuration
ENV APACHE_RUN_DIR=/var/run/apache2
ENV APACHE_PID_FILE=/var/run/apache2/apache2.pid
ENV APACHE_LOCK_DIR=/var/lock/apache2
ENV APACHE_LOG_DIR=/var/log/apache2
ENV PORT=10000

EXPOSE 10000

# Start Apache
CMD ["apache2-foreground"]
