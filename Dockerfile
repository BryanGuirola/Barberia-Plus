# Imagen base con Apache + PHP 8.2
FROM php:8.2-apache

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev zip npm \
    && docker-php-ext-install pdo_pgsql

# Habilitar mod_rewrite
RUN a2enmod rewrite headers

# Copiar el proyecto
WORKDIR /var/www
COPY . .

# Instalar composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Compilar Vite
RUN npm install && npm run build

# Permisos
RUN chown -R www-data:www-data storage bootstrap/cache

# Copiar configuración Apache
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Start script
COPY start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 8080

CMD ["/start.sh"]


