#!/bin/sh
sleep 10
php artisan config:clear
php artisan migrate --force
php artisan serve --host=0.0.0.0 --port=$PORT