#!/bin/sh

php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

apachectl -D FOREGROUND
