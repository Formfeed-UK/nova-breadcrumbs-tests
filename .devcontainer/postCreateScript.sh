#!/bin/bash

apt-get update

cd /workspace

cp .env.example .env
git submodule init
git submodule update
rm -f composer.lock
composer install
php artisan key:generate
php artisan storage:link
php artisan dusk:install
php artisan nova:install

php artisan migrate
yarn install
yarn run development
