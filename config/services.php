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

    'openai' => [
        'key' => env('OPENAI_API_KEY'),
    ],

    'gemini' => [
        'key' => env('GEMINI_API_KEY'),
        // Primary model. Verified working against the Gemini v1beta generateContent API.
        'model' => env('GEMINI_MODEL', 'gemini-3.5-flash'),
        // Tried in order if the primary is unavailable (404/429/5xx).
        'fallback_models' => array_values(array_filter(array_map(
            'trim',
            explode(',', (string) env('GEMINI_FALLBACK_MODELS', 'gemini-3.1-flash-lite,gemini-3.5-flash-lite'))
        ))),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
