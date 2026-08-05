# ---------- Etapa 1: build de assets (Tailwind v4 + Vite) ----------
FROM node:20-alpine AS node-build
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# ---------- Etapa 2: dependencias de Composer ----------
# Sin --no-dev: esta imagen es para desarrollo local (Pint, Pest, Boost incluidos),
# igual que el vendor/ que ya tenés instalado en el host.
FROM composer:2 AS vendor-build
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader --prefer-dist --ignore-platform-reqs

# ---------- Etapa 3: imagen PHP-FPM con el código de Laravel ----------
FROM php:8.4-fpm-alpine AS app

# Dependencias del sistema y extensiones PHP que Laravel necesita
RUN apk add --no-cache \
        bash \
        git \
        curl \
        libpng-dev \
        libzip-dev \
        oniguruma-dev \
        mariadb-client \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

COPY docker/conf/local.ini /usr/local/etc/php/conf.d/local.ini

WORKDIR /var/www/html

# Composer (por si hace falta correrlo dentro del contenedor)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Código de la app
COPY . .

# Dependencias y assets ya compilados en las etapas anteriores
COPY --from=vendor-build /app/vendor ./vendor
COPY --from=node-build /app/public/build ./public/build

RUN composer dump-autoload --optimize \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 9000
ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]
