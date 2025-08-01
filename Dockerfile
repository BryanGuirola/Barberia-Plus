# Imagen base con PHP y extensiones necesarias
FROM php:8.2-cli

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    unzip git libpq-dev nodejs npm curl zip \
    && docker-php-ext-install pdo pdo_pgsql

# Instalar Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Establecer el directorio de trabajo
WORKDIR /app

# Copiar archivos del proyecto
COPY . .

# Asignar permisos a storage y bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Compilar assets con Vite (si aplica)
RUN npm install && npm run build

# Generar clave de aplicación (si no existe)
RUN php artisan key:generate || true

# Cachear configuración y rutas
RUN php artisan config:clear \
    && php artisan cache:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Ejecutar migraciones en producción (con --force para evitar confirmaciones)
RUN php artisan migrate --force

# Exponer el puerto en Laravel
EXPOSE 8000

# Iniciar el servidor
CMD php artisan serve --host=0.0.0.0 --port=8000

