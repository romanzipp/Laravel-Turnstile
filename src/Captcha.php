<?php

namespace romanzipp\Turnstile;

use Illuminate\Support\HtmlString;

class Captcha
{
    public static function getScript(): HtmlString
    {
        return new HtmlString('<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>');
    }

    public static function getChallenge(string $theme = 'auto', string $action = ''): HtmlString
    {
        $parameters = collect([
            'class' => 'cf-turnstile',
            'data-sitekey' => config('turnstile.site_key'),
            'data-theme' => $theme,
            'data-action' => $action,
        ])
            // Remove empty values
            ->filter()
            // Create key="value"
            ->map(function ($item, $key) {
                return "{$key}=\"{$item}\"";
            })
            ->implode(' ');

        return new HtmlString(
            sprintf('<div %s></div>', $parameters)
        );
    }
}
