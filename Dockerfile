# Imagen base oficial de PHP con Composer incluido
FROM php:8.2-cli

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    unzip git libpq-dev nodejs npm \
    && docker-php-ext-install pdo pdo_pgsql

# Configurar el directorio de trabajo
WORKDIR /app

# Copiar el proyecto completo
COPY . .

# Instalar dependencias de PHP
RUN composer install --no-dev --optimize-autoloader

# Compilar assets (si usas Vite/Tailwind)
RUN npm install && npm run build

# Comandos de cacheo de Laravel
RUN php artisan config:cache

# Exponer el puerto (Render pasa $PORT automáticamente)
EXPOSE $PORT

# Comando de inicio
CMD php artisan serve --host 0.0.0.0 --port=$PORT