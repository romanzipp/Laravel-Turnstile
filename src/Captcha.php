<?php

namespace romanzipp\Turnstile;

use Illuminate\Support\HtmlString;

class Captcha
{
    public static function getScript(): HtmlString
    {
        return new HtmlString('<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>');
    }

    public static function getChallenge(): HtmlString
    {
        return new HtmlString(
            sprintf('<div class="cf-turnstile" data-sitekey="%s"></div>', config('turnstile.site_key'))
        );
    }
}
