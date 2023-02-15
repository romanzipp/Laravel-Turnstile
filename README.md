# Laravel Turnstile

[![Latest Stable Version](https://img.shields.io/packagist/v/romanzipp/laravel-turnstile.svg?style=flat-square)](https://packagist.org/packages/romanzipp/laravel-turnstile)
[![Total Downloads](https://img.shields.io/packagist/dt/romanzipp/laravel-turnstile.svg?style=flat-square)](https://packagist.org/packages/romanzipp/laravel-turnstile)
[![License](https://img.shields.io/packagist/l/romanzipp/laravel-turnstile.svg?style=flat-square)](https://packagist.org/packages/romanzipp/laravel-turnstile)
[![GitHub Build Status](https://img.shields.io/github/actions/workflow/status/romanzipp/Laravel-Turnstile/tests.yml?style=flat-square&label=Tests)](https://github.com/romanzipp/Laravel-Turnstile/actions)
[![GitHub Build Status](https://img.shields.io/github/actions/workflow/status/romanzipp/Laravel-Turnstile/phpstam.yml?style=flat-square&label=PHPStan)](https://github.com/romanzipp/Laravel-Turnstile/actions)
[![GitHub Build Status](https://img.shields.io/github/actions/workflow/status/romanzipp/Laravel-Turnstile/php-cs-fixer.yml?style=flat-square&label=PHP-CS-Fixer)](https://github.com/romanzipp/Laravel-Turnstile/actions)

[Cloudflare Turnstile](https://blog.cloudflare.com/turnstile-private-captcha-alternative/) CAPTCHA package for Laravel.

![](https://blog.cloudflare.com/content/images/2022/09/image4-21.png)

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

### Laravel Rule

```php
use romanzipp\Turnstile\Rules\TurnstileCaptcha;

$payload = $request->validate([
    'cf-turnstile-response' => ['required', 'string', new TurnstileCaptcha()],
]);
```

### Templates

#### Document head

Injects the [script tag](https://developers.cloudflare.com/turnstile/get-started/client-side-rendering/). See [method signature](/src/Captcha.php) for more options.

```blade
{{ romanzipp\Turnstile\Captcha::getScript() }}
```

#### Form

Injects the [form element](https://developers.cloudflare.com/turnstile/get-started/client-side-rendering/). See [method signature](/src/Captcha.php) for more options.

```blade
{{ romanzipp\Turnstile\Captcha::getChallenge() }}
```

---

### Manual validation (optional)

```php
use romanzipp\Turnstile\Validator;

$validator = new Validator();
$response = $validator->validate('input-token');

if ($response->isValid()) {
    return true;
}

echo $response->getMessage();
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
