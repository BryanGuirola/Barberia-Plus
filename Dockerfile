# Imagen base oficial con PHP, FPM y extensiones comunes
FROM php:8.2-fpm

# Instalar dependencias necesarias del sistema
RUN apt-get update && apt-get install -y \
    git unzip curl libpq-dev nodejs npm zip \
    && docker-php-ext-install pdo pdo_pgsql

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos del proyecto
COPY . .

# Dar permisos necesarios
RUN chmod -R 775 storage bootstrap/cache

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Instalar y compilar assets si usas Vite
RUN npm install && npm run build

# Cache de Laravel
RUN php artisan config:clear \
 && php artisan cache:clear \
 && php artisan route:clear \
 && php artisan view:clear \
 && php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache

# Exponer puerto
EXPOSE 8000

# Comando de inicio
CMD php artisan serve --host=0.0.0.0 --port=8000