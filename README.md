# Avoids circular reference when serializing Eloquent Models

This is a proof of concept for PR https://github.com/laravel/framework/pull/52461

Relevant code is within trait `App\Models\AvoidsCircularReference`

Test command is within `./routes/console.php`

## Installation

```
git clone https://github.com/rodrigopedra/circular
cd circular
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan circular
```
