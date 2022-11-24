#!/bin/bash

apt-get update
wget https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb -O /tmp/chrome.deb
apt-get install -y /tmp/chrome.deb
rm /tmp/chrome.deb

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
