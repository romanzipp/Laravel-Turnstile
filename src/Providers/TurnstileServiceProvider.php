<?php

namespace romanzipp\Turnstile\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use romanzipp\Turnstile\Rules\TurnstileCaptcha;

class TurnstileServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            dirname(__DIR__) . '/../config/turnstile.php' => config_path('turnstile.php'),
        ], 'config');

        Validator::extend('turnstile', TurnstileCaptcha::class);
        Validator::extend('turnstile_captcha', TurnstileCaptcha::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/../config/turnstile.php',
            'turnstile'
        );
    }
}
