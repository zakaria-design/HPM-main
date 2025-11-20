#!/bin/bash
composer install --no-dev --prefer-dist --optimize-autoloader
npm install
npm run build
