<?php

return [
    'site_key' => env('TURNSTILE_SITE_KEY'),
    'site_secret' => env('TURNSTILE_SECRET_KEY'),

    // Include visitor IP adresse in verify challenge data
    'include_ip' => false,
];
