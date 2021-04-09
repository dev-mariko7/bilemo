#BileMo

Symfony project BileMo (PHP-SYMFONY)

## How to install the project

### Requirements

- Symfony CLI
- Insomnia (for testing API)

### Installation and configuration

Please clone the project

####create and edit .env.local file

- `create .env.local file to root project`
- `add the line DATABASE_URL and complete it following the`[Doctrine rules](https://symfony.com/doc/current/doctrine.html)

Run the following commands:

>- `Symfony composer install`
>- `php bin/console doctrine:database:create`
>- `php bin/console make:migration`
>- `php bin/console doctrine:migrations:migrate`

## Development process

Check the PSR 1 and PSR 2
>- runt the following command : `php bin/phpunit`

Add data fixtures
>- `php bin/console doctrine:fixtures:load`

Load the project
>- `php -S 127.0.0.1:8000 -t public`

## How to run unit tests

Load unit tests
- runt the following command : `php bin/phpunit`

## How to test API

Dowload and install INSOMNIA. After that, following the technical documention API bilemo available on api/doc
