<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'perspective' => [
        'api_key' => env('PERSPECTIVE_API_KEY'),
        'attributes' => explode(',', env('PERSPECTIVE_ATTRIBUTES', 'TOXICITY')),
        'language_hints' => explode(',', env('PERSPECTIVE_LANGUAGE_HINTS', 'de,en')),
        'block_threshold' => (float) env('PERSPECTIVE_BLOCK_THRESHOLD', 0.75),
        'moderate_threshold' => (float) env('PERSPECTIVE_MODERATE_THRESHOLD', 0.60),
        'timeout' => (int) env('PERSPECTIVE_TIMEOUT', 4)
    ]

];
