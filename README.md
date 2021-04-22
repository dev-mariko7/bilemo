#BileMo

Symfony project BileMo (PHP-SYMFONY)

## How to install the project

### Requirements

- Symfony CLI

### Installation and configuration

Please clone the project

####create and edit .env.local file

- create `.env.local` file to root project
- add the line `DATABASE_URL` and complete it following the[Doctrine rules](https://symfony.com/doc/current/doctrine.html)

Run the following commands:

>- `symfony composer install`
>- `php bin/console doctrine:database:create`
>- `php bin/console doctrine:migrations:migrate`

## Development process

Add data fixtures
>- `php bin/console doctrine:fixtures:load`

Load the project
>- `php -S 127.0.0.1:8000 -t public`

## How to run unit tests

Load unit tests
- runt the following command : `php bin/phpunit`

## How to create the private key and public key for generate token

- run command : `php bin/console lexik:jwt:generate-keypair`

## How to test API

Dowload and install INSOMNIA. After that, following the technical documention API bilemo available on api/doc
To get the token you have to send the user infos on api/login_check like this
>
>{
>   "username": "username1",
>   "password": "password1"
>}

when you obtained the token it is necessary to include it in the requests of API who requires token
