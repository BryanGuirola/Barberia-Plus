# Imagen base oficial de PHP con FPM
FROM php:8.2-fpm

# Instalar dependencias del sistema necesarias
RUN apt-get update && apt-get install -y \
    git unzip curl libpq-dev zip libzip-dev \
    libxml2-dev libonig-dev nodejs npm \
    && docker-php-ext-install pdo pdo_pgsql bcmath mbstring ctype fileinfo zip


# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Copiar los archivos del proyecto
COPY . .

# Asegurar permisos a los directorios necesarios
RUN chmod -R 775 storage bootstrap/cache

# Instalar dependencias PHP (modo producción)
RUN composer install --no-dev --optimize-autoloader --no-interaction


# Instalar dependencias JS y compilar assets
RUN npm install && npm run build

# Cache de Laravel
RUN php artisan config:clear \
 && php artisan cache:clear \
 && php artisan route:clear \
 && php artisan view:clear \
 && php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache

# Exponer puerto para Laravel serve
EXPOSE 8000

# Comando de inicio
CMD php artisan serve --host=0.0.0.0 --port=8000
