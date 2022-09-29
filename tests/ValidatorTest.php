<?php

namespace romanzipp\Turnstile\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Mockery;
use romanzipp\Turnstile\Validator;

class ValidatorTest extends TestCase
{
    public function testSuccess()
    {
        $response = (new Validator(
            self::getClient(200, ['success' => true])
        ))->isValid('foo');

        self::assertTrue($response->valid);
    }

    public function testMissingBody()
    {
        $response = (new Validator(
            self::getClient(200, [])
        ))->isValid('foo');

        self::assertFalse($response->valid);
        self::assertSame('The CAPTCHA validation response is malformed', $response->getMessage());
    }

    public function testFailedSuccess()
    {
        $response = (new Validator(
            self::getClient(200, ['success' => false])
        ))->isValid('foo');

        self::assertFalse($response->valid);
    }

    public function testClientError()
    {
        $response = (new Validator(
            self::getFailingClient(400, ['success' => false, 'error-codes' => ['test']], ClientException::class)
        ))->isValid('foo');

        self::assertFalse($response->valid);
    }

    public function testClientErrorWithCode()
    {
        $response = (new Validator(
            self::getFailingClient(400, ['success' => false, 'error-codes' => ['foo']], ClientException::class)
        ))->isValid('foo');

        self::assertFalse($response->valid);
        self::assertSame(['foo'], $response->errors);
    }

    public function testServerError()
    {
        $response = (new Validator(
            self::getFailingClient(500, ['success' => false, 'error-codes' => ['test']], ServerException::class)
        ))->isValid('foo');

        self::assertFalse($response->valid);
    }

    public function testServerErrorWithAllowConfig()
    {
        config(['turnstile.allow_on_failure' => true]);

        $response = (new Validator(
            self::getFailingClient(500, ['success' => false, 'error-codes' => ['test']], ServerException::class)
        ))->isValid('foo');

        self::assertTrue($response->valid);
    }

    private static function getFailingClient(int $status, array $response, string $exception)
    {
        $client = Mockery::mock(Client::class);
        $client
            ->expects('post')
            ->andThrow(new ($exception)('Error', new Request('POST', '/'), new Response($status, [], json_encode($response))));

        return $client;
    }

    private static function getClient(int $status, array $response)
    {
        $client = Mockery::mock(Client::class);
        $expect = $client->expects('post')->andReturn(new Response($status, [], json_encode($response)));

        return $client;
    }
}
