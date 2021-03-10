#!/bin/bash

DB=/data/db.sqlite
if [ ! -f "$DB" ]; then
    touch $DB
fi

php artisan migrate
php artisan serve --host=0.0.0.0 --port=8000
