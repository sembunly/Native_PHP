# Sample CRM - Native PHP MVC

This application uses native PHP, PDO, MySQL, and Composer PSR-4 autoloading. It has no PHP framework.

## Requirements

- PHP 8.1 or newer with `pdo_mysql`
- MySQL
- Composer
- Apache `mod_rewrite` enabled (or configure the web server to send routes to `public/index.php`)

## Setup

1. From the project directory, run `composer install` to install PHPUnit and generate the PSR-4 autoloader.
2. Copy `.env.example` to `.env` and set `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, and `DB_PASS` for your MySQL installation. `.env` is ignored by Git.
3. Create the database named by `DB_NAME` (defaults to `customers_db`), then import `database/migrations/001_create_users.sql` and `database/migrations/002_create_members.sql` in that order.
4. Import `database/seeds/admin_user.sql` for the original local demo account (`admin` / `1`). The first successful login upgrades this legacy password to a `password_hash()` value. Change the demo password after logging in.
5. Point Apache's document root at this project's `public/` folder. With WAMP's default document root, open `http://localhost/raw-php/public/`. The root `index.php` redirects there for convenience.

## Routes

- `/login`, `/logout`
- `/dashboard`
- `/members`, `/members/create`, `/members/edit?id=1`, `/members/delete` (POST)

## Project layout

- `app/Controllers/` handles HTTP requests and chooses views.
- `app/Models/` contains PDO queries for users and members.
- `app/Services/` contains authentication logic.
- `app/Views/` contains login, dashboard, and member screens.
- `config/` contains database configuration loaded from `.env`.
- `database/migrations/` and `database/seeds/` contain SQL setup files.
- `public/` is the web entry point and holds public assets.
- `resources/layouts/` contains shared page chrome.
- `routes/web.php` maps request paths to controllers.
- `storage/logs/` is reserved for application logs.
- `tests/` contains PHPUnit tests.

Run the test suite with `vendor/bin/phpunit tests` after running `composer install`.
