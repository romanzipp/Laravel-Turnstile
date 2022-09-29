<?php

return [
    'site_key' => env('TURNSTILE_SITE_KEY'),
    'secret_key' => env('TURNSTILE_SECRET_KEY'),

    // Include visitor IP adresse in verify challenge data
    'include_ip' => false,
];
