# --- Imagen base PHP FPM ---
FROM php:8.2-fpm

# --- Instalar dependencias del sistema ---
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev zip nodejs npm \
    && docker-php-ext-install pdo_pgsql

# --- Instalar Composer global ---
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# --- Directorio raíz del proyecto ---
WORKDIR /var/www

# --- Copiar proyecto ---
COPY . .

# --- Crear .env desde .env.example ---
RUN cp .env.example .env

# --- Permisos de Laravel ---
RUN chmod -R 775 storage bootstrap/cache

# --- Instalar dependencias PHP ---
RUN composer install --no-dev --optimize-autoloader --no-interaction

# --- Compilar frontend (Vite) ---
RUN npm install && npm run build

# --- Generar clave APP_KEY dentro del contenedor ---
RUN php artisan key:generate

# --- Limpiar y generar caches ---
RUN php artisan config:clear \
 && php artisan route:clear \
 && php artisan view:clear \
 && php artisan cache:clear \
 && php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache

# --- Crear storage link (si falla, continuar) ---
RUN php artisan storage:link || true

# --- Exponer el puerto FPM ---
EXPOSE 9000

# --- Iniciar PHP-FPM ---
CMD ["php-fpm", "-F"]

