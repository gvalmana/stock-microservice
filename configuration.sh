#! /bin/bash
php artisan config:cache
php artisan config:clear
php artisan cache:clear
php artisan queue:restart
php artisan view:clear
#php artisan migrate
