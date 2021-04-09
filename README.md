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

## How to create the keys for create token
// ajouter api/login_check in README
// username password dans le README 
// supprimer les versions bdd
//commande pour creer le token et les dossier qui vont bien https://blog.xebia.fr/2010/06/25/rest-richardson-maturity-model/
// api/doc doit être public
// pagination (telephone et users) expliquer comment aller aux pages suivantes
// NO ROUTE FOUND / attraper l'exception
// 404 quand ca existe pas et retourner un message a chaque fois
//changer les 204 en 404
// commande php csfixer
// niveau 3 de richardson voir https://openclassrooms.com/fr/courses/4087036-construisez-une-api-rest-avec-symfony/4343816-rendez-votre-api-auto-decouvrable-dernier-niveau-du-modele-de-maturite-de-richardson
