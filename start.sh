#!/bin/sh
touch database/database.sqlite
php artisan config:clear
php artisan migrate --force || true
php artisan db:seed --force || true
exec php -S 0.0.0.0:${PORT:-8000} -t public
