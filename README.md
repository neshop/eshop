# Eshop
Simple ecommerce solution based on Nette PHP Framework with Doctrine ORM.

## Requirements
- PHP >= 5.6
- composer
- bower
- database (tested and developed on MySQL)


## How to install
1. set web document root to `__PATH__/src/www/`
2. rename `src/app/config/config.local.example.neon` file to `src/app/config/config.local.neon` and fill correct values
3. run `composer install` for install all PHP dependencies
4. run `php src/www/index.php orm:schema:create` for create database schema
5. run `php src/www/index.php orm:default-data:load` for load default data
6. run `cd src/www`
7. run `bower install` for install all frontend dependencies
8. now just open web URL in favorite web browser
9. profit :-)

Now you can login into administration (www.your-domain.com/admin) with login `admin@example.com` and password `123456`

## Contributions
- please respect [PSR-2 conding standards](http://www.php-fig.org/psr/psr-2/)
