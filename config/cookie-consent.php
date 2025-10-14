<?php

return [
    'enabled' => env('COOKIE_CONSENT_ENABLED', true),

    'cookie_name' => 'laravel_cookie_consent',

    'cookie_lifetime' => 365 * 24 * 60 * 60, // Ein Jahr

    'cookie_domain' => env('SESSION_DOMAIN', null),

    'cookie_same_site' => env('SESSION_SAME_SITE', null),

    'cookie_secure' => env('SESSION_SECURE_COOKIE', false),
];
