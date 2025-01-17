# Laravel + Passport Boilerplate

## Requirements
- Composer: ^2.0
- PHP: ^8.2

## How to run this API locally
- clone this repo
- run `composer install`
- run `php artisan key:generate`
- run `php artisan migrate`
- run `php artisan passport:client --password`
- copy the client_id & client_secret from above command to `.env` file
- make sure to run `php artisan optimize` after you made some changes to `.env`
- finally run `php artisan serve` and you are ready.