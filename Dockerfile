FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    unzip git curl libpq-dev nodejs npm zip \
 && docker-php-ext-install pdo_pgsql pgsql

RUN curl -sS https://getcomposer.org/installer | php \
 && mv composer.phar /usr/local/bin/composer

WORKDIR /app
COPY . .

RUN chmod -R 775 storage bootstrap/cache
RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN npm install && npm run build  

RUN php artisan config:clear \
 && php artisan route:clear \
 && php artisan view:clear \
 && php artisan cache:clear \
 && php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache

# MUESTRA en build qué extensiones están activas (opcional, para debugging)
RUN php -m | grep -E 'pdo|pgsql'

COPY start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 8000
CMD ["/start.sh"]

