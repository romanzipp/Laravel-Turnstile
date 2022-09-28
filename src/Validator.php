<?php

namespace romanzipp\Turnstile;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;

class Validator
{
    public function isValid(string $token): ValidationResponse
    {
        $formData = [
            'secret' => config('turnstile.site_secret'),
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
                'form_data' => $formData,
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);

            $data = json_decode((string) $response->getBody()->getContents());

            if ( ! property_exists($data, 'success')) {
                return new ValidationResponse(false);
            }

            if ( ! $data->success){
                return new ValidationResponse(false, $data->{'error-codes'});
            }

            return new ValidationResponse(true);
        } catch (ClientException $exception) {
            // TODO Add config to return true if call fails due to another reason
            return new ValidationResponse(false);
        } catch (\Throwable $exception) {
            return new ValidationResponse(false);
        }
    }
}
