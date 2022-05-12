#!/bin/bash

mkdir -p \
  /var/www/storage/framework/views \
  /var/www/storage/framework/testing \
  /var/www/storage/framework/sessions \
  /var/www/storage/framework/cache/data \
  /var/www/storage/app/public \
  /var/www/storage/logs

touch /var/www/storage/db.sqlite
chown -R 33:33 /var/www/storage

php artisan cartridge:init

echo "✈ Starting server..."
apache2-foreground
