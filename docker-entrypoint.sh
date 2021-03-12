#!/bin/bash

php artisan cartridge:init

echo "✈ Starting server..."
apache2-foreground
