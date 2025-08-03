#!/bin/sh
# Espera a que la base de datos esté lista
sleep 10

# Corre migraciones (solo una vez por arranque)
php artisan migrate --force

# Inicia el servidor de Laravel
php artisan serve --host=0.0.0.0 --port=$PORT