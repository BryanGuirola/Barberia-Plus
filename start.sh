#!/bin/sh

# Esperar a que la base de datos esté lista
sleep 10

# Limpiar caché de configuración (por si cambiaste env)
php artisan config:clear

# Ejecutar migraciones
php artisan migrate --force

# Ejecutar seeders
php artisan db:seed --force

# Iniciar servidor Laravel
php artisan serve --host=0.0.0.0 --port=$PORT