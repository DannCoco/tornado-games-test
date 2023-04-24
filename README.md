# Tornado-Games-Test

This project was generated with (https://symfony.com/doc/current/setup.html#symfony-lts-versions)

## Development server

Have the latest version of Docker installed 

## App code

Clone the project from the following path (https://github.com/DannCoco/tornado-games-test.git).

## Running backend application

Run docker compose up -d --build to build docker images.
Run docker exec -it php bash to access the project

## Symfony configuration

Run composer require symfony/runtime
RUN php bin/console doctrine:migrations:migrate
Run Example: php bin/console app:currency:rates EUR USD JPY BGN (https://freecurrencyapi.com/docs/currency-list)
Run Example: http://localhost/api/exchange-rates?base_currency=EUR&target_currencies=[USD,JPY,BGN] 


## Running tests unit

---------------------EMPTY------------------------------------------------------------