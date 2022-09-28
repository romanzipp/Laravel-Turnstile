<?php

namespace romanzipp\Turnstile\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use romanzipp\Turnstile\Providers\TurnstileProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            TurnstileProvider::class,
        ];
    }
}
