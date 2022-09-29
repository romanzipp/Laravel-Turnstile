<?php

namespace romanzipp\Turnstile;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Throwable;

class Validator
{
    public function isValid(?string $token): ValidationResponse
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
            $client = new Client();
            $response = $client->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'form_params' => $formData,
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);

            $data = json_decode($response->getBody()->getContents());

            if ( ! property_exists($data, 'success')) {
                return new ValidationResponse(false);
            }

            if ( ! $data->success) {
                return new ValidationResponse(false, $data->{'error-codes'});
            }

            return new ValidationResponse(true);
        } catch (RequestException $exception) {
            if ( ! $exception->hasResponse() || 0 === $exception->getResponse()->getBody()->getSize()) {
                return new ValidationResponse(false);
            }

            $data = @json_decode($exception->getResponse()->getBody()->getContents());

            return new ValidationResponse(false, $data->{'error-codes'} ?? []);
        } catch (Throwable $exception) {
            // TODO Add config to return true if call fails due to another reason
            return new ValidationResponse(false, [$exception->getMessage()]);
        }
    }
}
