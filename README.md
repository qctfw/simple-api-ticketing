# Simple API Ticketing
Simple API Ticketing with Laravel framework.

## Installation
- Install Composer dependencies
  ```bash
  composer install
  ```
- Copy `.env.example` to `.env` and edit these values.
  ```bash
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=simple_api_ticketing
  DB_USERNAME=root
  DB_PASSWORD=password
  ```
- Migrate the database.
  ```bash
  php artisan migrate
  ```
  **Note:** Add `--seed` option to seed the database.
