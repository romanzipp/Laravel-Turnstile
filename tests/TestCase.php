<?php

namespace romanzipp\Turnstile\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use romanzipp\Turnstile\Providers\TurnstileServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            TurnstileServiceProvider::class,
        ];
    }
}
