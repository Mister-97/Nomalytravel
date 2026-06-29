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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Translation Services
    |--------------------------------------------------------------------------
    |
    | API keys for various translation services
    |
    */
    'google' => [
        'translate_api_key' => env('GOOGLE_TRANSLATE_API_KEY'),
    ],

    'deepl' => [
        'api_key' => env('DEEPL_API_KEY'),
    ],

    'libre' => [
        'api_key' => env('LIBRE_TRANSLATE_API_KEY'),
        'base_url' => env('LIBRE_TRANSLATE_BASE_URL', 'https://libretranslate.com'),
    ],

    'stripe' => [
        'key'    => env('STRIPE_KEY', ''),
        'secret' => env('STRIPE_SECRET', ''),
    ],

    'paypal' => [
        'mode' => env('PAYPAL_MODE', 'sandbox'),
        'client_id' => env('PAYPAL_CLIENT_ID'),
        'client_secret' => env('PAYPAL_CLIENT_SECRET'),
    ],

    'paystack' => [
        'public_key' => env('PAYSTACK_PUBLIC_KEY'),
        'secret_key' => env('PAYSTACK_SECRET_KEY'),
        'merchant_email' => env('PAYSTACK_MERCHANT_EMAIL'),
        'url' => env('PAYSTACK_URL', 'https://api.paystack.co'),
    ],

    'hotelbeds' => [
        'api_key'  => env('HOTELBEDS_API_KEY'),
        'secret'   => env('HOTELBEDS_SECRET'),
        'base_url' => env('HOTELBEDS_BASE_URL', 'https://api.test.hotelbeds.com'),
    ],

    'ticketmaster' => [
        'key' => env('TICKETMASTER_KEY'),
        'secret' => env('TICKETMASTER_SECRET'),
    ],

    'liteapi' => [
        'key' => env('LITEAPI_KEY'),
    ], 
  'ticketsqueeze' => [
'key' => env('TICKETSQUEEZE_API_KEY'),
],


    "travelpayouts" => [
        "token"  => env("TRAVELPAYOUTS_TOKEN", ""),
        "marker" => env("TRAVELPAYOUTS_MARKER", ""),
    ],

    'ticketnetwork' => [
        'consumer_key'    => env('TN_CONSUMER_KEY'),
        'consumer_secret' => env('TN_CONSUMER_SECRET'),
        'wcid'            => env('TN_WCID_CATALOG', '23884'),
        'bid'             => env('TN_BID', '14126'),
    ],
];
