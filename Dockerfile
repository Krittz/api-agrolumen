# Stage 1: Composer dependencies
FROM composer:2 as vendor

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

# Stage 2: Production build
FROM composer:2 as prod-builder

WORKDIR /app

COPY composer.json composer.lock ./
COPY --from=vendor /app/vendor ./vendor/

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

# Stage 3: Runtime (production)
FROM php:8.3-fpm-alpine as production

WORKDIR /var/www/html

# Install production dependencies only
RUN apk add --no-cache \
    libzip \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip \
    && apk del libzip-dev

# Use production PHP configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Copy application and dependencies
COPY . .
COPY --from=prod-builder /app/vendor/ ./vendor/

# Set permissions
RUN chown -R www-data:www-data /var/www/html

USER www-data

EXPOSE 9000

CMD ["php-fpm"]
