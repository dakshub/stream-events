# Stream Events

## Demo

## Technology Stack

- Laravel ([Breeze](https://laravel.com/docs/starter-kits), [Sanctum](https://laravel.com/docs/sanctum), [Socialite](https://laravel.com/docs/socialite))
- Next.js
- MySQL
- PHP Unit (Testing)

## Run Application Locally

1. See official [Starter Kit](https://laravel.com/docs/10.x/starter-kits#breeze-and-next) documentation to set up local development environment
2. Clone this repository
3. Get `GITHUB_CLIENT_ID` `GITHUB_CLIENT_SECRET` and `GITHUB_REDIRECT_URI` and set these values in `.env`
4. Run `npm install` in the frontend directory and `composer install` in the backend directory
5. Install `MySQL` and run `php artisan migrate:refresh --seed` to create database tables and seed data
6. Run `npm run dev` in frontend directory and `php artisan serve` in backend directory
7. Run `php artisan test` in backend directory to run tests
8. Visit `http://localhost:3000` to see the frontend; backend is available at `http://localhost:8000`
