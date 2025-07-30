# Imagen base oficial de PHP
FROM php:8.2-cli

# Instalar dependencias necesarias (Postgres, Node y herramientas para Composer)
RUN apt-get update && apt-get install -y \
    unzip git libpq-dev nodejs npm curl \
    && docker-php-ext-install pdo pdo_pgsql

# Instalar Composer manualmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configurar el directorio de trabajo
WORKDIR /app

# Copiar el proyecto completo
COPY . .

# 🔹 Dar permisos de escritura a storage y bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Instalar dependencias de PHP
RUN composer install --no-dev --optimize-autoloader

# (opcional) Compilar assets si usas Vite/Tailwind
# RUN npm install && npm run build

# Comandos de cacheo de Laravel
RUN php artisan config:clear
RUN php artisan cache:clear
RUN php artisan route:clear
RUN php artisan view:clear
RUN php artisan config:cache

# Exponer el puerto (Render pasa $PORT automáticamente)
EXPOSE $PORT

# Comando de inicio
CMD php artisan serve --host 0.0.0.0 --port=$PORT
