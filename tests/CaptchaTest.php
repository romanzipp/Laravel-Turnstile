<?php

namespace romanzipp\Turnstile\Tests;

use romanzipp\Turnstile\Captcha;

class CaptchaTest extends TestCase
{
    public function testChallenge()
    {
        self::assertSame('<div class="cf-turnstile"></div>', (string) Captcha::getChallenge());
        self::assertSame('<div class="cf-turnstile" data-theme="dark"></div>', (string) Captcha::getChallenge('dark'));
        self::assertSame('<div class="cf-turnstile" data-action="foo"></div>', (string) Captcha::getChallenge(null, 'foo'));
        self::assertSame('<div class="cf-turnstile" data-cdata="foo"></div>', (string) Captcha::getChallenge(null, null, 'foo'));

        self::assertSame('<div class="cf-turnstile" data-theme="dark" data-action="foo"></div>', (string) Captcha::getChallenge('dark', 'foo'));
        self::assertSame('<div class="cf-turnstile" data-theme="dark" data-action="foo" data-cdata="bar"></div>', (string) Captcha::getChallenge('dark', 'foo', 'bar'));
    }

    public function testScript()
    {
        self::assertSame('<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>', (string) Captcha::getScript());
        self::assertSame('<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>', (string) Captcha::getScript(true, true));
        self::assertSame('<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" defer></script>', (string) Captcha::getScript(false, true));
        self::assertSame('<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" ></script>', (string) Captcha::getScript(false, false));
        self::assertSame('<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer data-callback="cb"></script>', (string) Captcha::getScript(true, true, 'cb'));
        self::assertSame('<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" defer data-callback="cb"></script>', (string) Captcha::getScript(false, true, 'cb'));
        self::assertSame('<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async data-callback="cb"></script>', (string) Captcha::getScript(true, false, 'cb'));
        self::assertSame('<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" data-callback="cb"></script>', (string) Captcha::getScript(false, false, 'cb'));
    }
}
