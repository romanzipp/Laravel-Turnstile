# Laravel Turnstile

[![Latest Stable Version](https://img.shields.io/packagist/v/romanzipp/laravel-turnstile.svg?style=flat-square)](https://packagist.org/packages/romanzipp/laravel-turnstile)
[![Total Downloads](https://img.shields.io/packagist/dt/romanzipp/laravel-turnstile.svg?style=flat-square)](https://packagist.org/packages/romanzipp/laravel-turnstile)
[![License](https://img.shields.io/packagist/l/romanzipp/laravel-turnstile.svg?style=flat-square)](https://packagist.org/packages/romanzipp/laravel-turnstile)
[![GitHub Build Status](https://img.shields.io/github/workflow/status/romanzipp/Laravel-Turnstile/Tests?style=flat-square)](https://github.com/romanzipp/Laravel-Turnstile/actions)

[Cloudflare Turnstile](https://blog.cloudflare.com/turnstile-private-captcha-alternative/) CAPTCHA package for Laravel.

## Installation

```
composer require romanzipp/laravel-turnstile
```

## Configuration

Copy configuration to project:

```
php artisan vendor:publish --provider="romanzipp\Turnstile\Providers\TurnstileServiceProvider"
```

Add environmental variables to your `.env`:

```
TURNSTILE_SITE_KEY=
TURNSTILE_SECRET_KEY=
```

## Usage

### Document Head

```blade
{{ romanzipp\Turnstile\Captcha::getScript() }}
```

### Form

```blade
{{ romanzipp\Turnstile\Captcha::getChallenge() }}
```

### Laravel Rule

```php
$payload = $request->validate([
    'cf-turnstile-response' => ['turnstile'],
]);
```

## Development

#### Run Tests

```shell
composer test
```

## License

Released under the [MIT License](LICENSE.md).

## Authors

- [Roman Zipp](https://github.com/romanzipp)
