# Laravel + Passport Boilerplate

## Requirements

-   Composer: ^2.0
-   PHP: ^8.2

## How to run this API locally

-   clone this repo
-   run `composer install`
-   run `php artisan key:generate`
-   run `php artisan migrate`
-   run `php artisan passport:key`
-   run `php artisan passport:client --password`
-   copy the client_id & client_secret from above command to `.env` file
-   make sure to run `php artisan optimize` after you made changes to `.env`
-   finally run `php artisan serve` and you are ready.

## How to setup Docker Container

-   run `docker-compose up -d` to start the container
-   run `docker-compose up --build -d` to start & build the container
-   run `docker-compose down` to stop

## How to enter to the Docker Container

-   run `docker exec -it <name> bash`

## Generate Swagger UI

-   run `php artisan l5-swagger:generate`
