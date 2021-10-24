## Quick Setup

- Clone this repository
- Execute: `composer install`
- Duplicate `.env.example` file as `.env`. And change the based on your local enviroment:
  - `DB_PORT=3306`
  - `DB_DATABASE=db_wallet`
  - `DB_USERNAME=YourDatabaseUser`
  - `DB_PASSWORD=YourDatabasepassword`
- Run `php -S localhost:8000 -t public`
- Setups is done and open your app at `http://localhost:8000`

## Run Migration & Test

- open folder root project
- Run `php artisan migrate`
- Run `php artisan db:seed`
- Run `vendor/bin/phpunit`

## Postman Collection
- Open Rest in root project folder