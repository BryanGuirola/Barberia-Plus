#!/bin/bash

# --- Ejecutar migraciones en segundo plano ---
php artisan migrate --force &

# Opcional: seeds
# php artisan db:seed --force &

# --- Iniciar Apache ---
apache2ctl -D FOREGROUND
