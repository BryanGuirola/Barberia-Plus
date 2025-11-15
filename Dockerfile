FROM php:8.2-fpm

# Dependencias necesarias
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev zip nodejs npm \
    && docker-php-ext-install pdo_pgsql

# Composer global
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copiar proyecto
COPY . .

# Permisos
RUN chmod -R 775 storage bootstrap/cache

# Instalar dependencias de PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Instalar y compilar frontend
RUN npm install && npm run build

# Generar app key (si no existe)
RUN php artisan key:generate

# Crear storage link
RUN php artisan storage:link || true

# Construir caches
RUN php artisan config:clear
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Exponer puerto FPM
EXPOSE 9000

CMD ["php-fpm"]
