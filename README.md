Requires Laravel

php artisan make:migrate install

Edit .env and add API_URL=https://api.github.com/search/repositories?q=language:php+sort:stars

change DB config to user/pass/host for local database configuration and APP_URL to current host
