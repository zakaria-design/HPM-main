#!/bin/bash

php artisan config:cache
php artisan route:cache
php artisan view:cache

npm run build

cp -R public public_build
