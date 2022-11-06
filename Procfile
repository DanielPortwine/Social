web: vendor/bin/heroku-php-nginx public/
release: php artisan migrate --force && php artisan cache:clear && php artisan config:cache