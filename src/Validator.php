<?php

namespace romanzipp\Turnstile;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;

class Validator
{
    public function isValid(string $token): bool
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

            if ( ! property_exists($data, 'success') || ! $data->success) {
                return false;
            }

            return true;
        } catch (ClientException $exception) {
            return false; // Add config to return true if call fails due to another reason
        } catch (\Throwable $exception) {
            return false;
        }
    }
}
