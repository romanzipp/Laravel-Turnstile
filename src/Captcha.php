<?php

namespace romanzipp\Turnstile;

use Illuminate\Support\HtmlString;

class Captcha
{
    public static function getScript(bool $async = true, bool $defer = true, ?string $callback = null): HtmlString
    {
        $attributes = [];

        if ($async) {
            $attributes[] = 'async';
        }

        if ($defer) {
            $attributes[] = 'defer';
        }

        if ( ! empty($callback)) {
            $attributes[] = 'data-callback="' . $callback . '"';
        }

        return new HtmlString(
            sprintf('<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" %s></script>', implode(' ', $attributes))
        );
    }

    public static function getChallenge(?string $theme = null, ?string $action = null, ?string $cData = null): HtmlString
    {
        $parameters = [
            'class' => 'cf-turnstile',
            'data-sitekey' => config('turnstile.site_key'),
            'data-theme' => $theme,
            'data-action' => $action,
            'data-cdata' => $cData,
        ];

        $parameters = array_filter($parameters, fn ($value, string $key) => ! empty($value), ARRAY_FILTER_USE_BOTH);

        return new HtmlString(
            sprintf(
                '<div %s></div>',
                implode(
                    ' ',
                    array_map(fn (string $key, $value) => "{$key}=\"{$value}\"", array_keys($parameters), array_values($parameters))
                )
            )
        );
    }
}
