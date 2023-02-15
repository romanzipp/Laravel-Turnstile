<?php

namespace romanzipp\Turnstile;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Http\Request;

class Validator
{
    private Client  $client;

    public function __construct(Client $client = null)
    {
        $this->client = $client ?? new Client();
    }

    public function validate(?string $token): ValidationResponse
    {
        $formData = [
            'secret' => config('turnstile.secret_key') ?: config('turnstile.site_secret'),
            'response' => $token,
        ];

        if (config('turnstile.include_ip')) {
            /** @var \Illuminate\Http\Request $request */
            $request = app(Request::class);
            $formData['remoteip'] = $request->ip();
        }

        try {
            $response = $this->client->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'form_params' => $formData,
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);

            $data = json_decode($response->getBody()->getContents());

            if ( ! ($data instanceof \stdClass) || ! property_exists($data, 'success')) {
                return new ValidationResponse(false, [ValidationResponse::INTERNAL_MALFORMED_RESPONSE]);
            }

            if ( ! $data->success) {
                return new ValidationResponse(false, $data->{'error-codes'} ?? []);
            }

            return new ValidationResponse(true);
        } catch (ServerException $exception) {
            if (config('turnstile.allow_on_failure')) {
                return new ValidationResponse(true);
            }

            return new ValidationResponse(false, [ValidationResponse::INTERNAL_SERVER_ERROR]);
        } catch (RequestException $exception) {
            if ( ! $exception->hasResponse() || 0 === $exception->getResponse()->getBody()->getSize()) {
                return new ValidationResponse(false);
            }

            $data = @json_decode($exception->getResponse()->getBody()->getContents());

            return new ValidationResponse(false, $data->{'error-codes'} ?? []);
        } catch (\Throwable $exception) {
            return new ValidationResponse(false, [$exception->getMessage()]);
        }
    }

    /**
     * @deprecated
     *
     * @param string|null $token
     *
     * @return \romanzipp\Turnstile\ValidationResponse
     */
    public function isValid(?string $token): ValidationResponse
    {
        return $this->validate($token);
    }
}
