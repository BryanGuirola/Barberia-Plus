# Imagen base oficial de PHP con extensiones necesarias
FROM php:8.2-cli

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    unzip git libpq-dev nodejs npm curl zip \
    && docker-php-ext-install pdo pdo_pgsql

# Instalar Composer manualmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Establecer directorio de trabajo
WORKDIR /app

# Copiar archivos del proyecto
COPY . .

# 🔹 Dar permisos de escritura a storage y bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Instalar dependencias de PHP (con --no-interaction por seguridad)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# (Opcional) Compilar assets si usas Vite
# (opcional) Compilar assets si usas Vite/Tailwind
# RUN npm install && npm run build

# Generar cache de configuración
# Comandos de cacheo de Laravel
RUN php artisan config:clear
RUN php artisan cache:clear
RUN php artisan route:clear
RUN php artisan view:clear
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Exponer el puerto usado por Laravel
EXPOSE 8000

# Comando de inicio
CMD php artisan serve --host=0.0.0.0 --port=8000
