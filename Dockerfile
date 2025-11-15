# Imagen base con Apache + PHP 8.2
FROM php:8.2-apache

# Cloud Run usa la variable $PORT, aseguramos que tenga valor 8080 por defecto
ENV PORT=8080

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev zip npm \
    && docker-php-ext-install pdo_pgsql

# Habilitar módulos necesarios de Apache
RUN a2enmod rewrite headers

# Ajustar Apache para escuchar en $PORT
RUN sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf \
    && sed -i "s/:80/:${PORT}/g" /etc/apache2/sites-available/000-default.conf

# Copiar proyecto
WORKDIR /var/www
COPY . .

# Instalar composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Compilar Vite
RUN npm install && npm run build

# Permisos Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# Asegurar que Apache use el docroot correcto
RUN sed -i "s|/var/www/html|/var/www/public|g" /etc/apache2/sites-available/000-default.conf

# Exponer el puerto real
EXPOSE 8080

# Start command
CMD ["apache2ctl", "-D", "FOREGROUND"]


