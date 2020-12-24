<?php

return [
    
    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */
    
    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],
    
    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],
    
    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],
    
    'stripe'   => [
        'model'  => App\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    
    // twilio
    'twilio'   => [
        'sid'             => env('TWILIO_ACCOUNT_SID'),
        'token'           => env('TWILIO_ACCOUNT_TOKEN'),
        'key'             => env('TWILIO_API_KEY'),
        'secret'          => env('TWILIO_API_SECRET'),
        'chat_service_id' => env('TWILIO_CHAT_SERVICE_SID')
    ],
    
    
    // socialite
    // facebook
    'facebook' => [
        'client_id'     => '1088775541286836', //Facebook API
        'client_secret' => 'b864c12868dd6be9b99a68bdb464f583', //Facebook Secret
        'redirect'      => '/student/login/facebook/callback',
    ],
    
    // google
    /*'google' => [
//            'client_id' => '975532697492-tleimtp1topboomjl1ulor9aqr1brmab.apps.googleusercontent.com',
//            'client_id' => '77555881403-r86h2u6h1roolvpkp7c8kdmo3flsv1c9.apps.googleusercontent.com', // farrukh - 1
//            'client_id' => '77555881403-ad5h29q9b5ohtbr0flke38b6fm15dbkd.apps.googleusercontent.com', // farrukh - 2
        'client_id' => '117060690267-3pftvt1r1jr3rtarlq89ve34d37nflu2.apps.googleusercontent.com', // Shoaib - 1
//            'client_secret' => 'B8FwqkNX8KrIO2G11t3GYCi5',
//            'client_secret' => 'wC-g5lE4wimxXF_0T5EXSq5P', // farrukh - 1
//            'client_secret' => 'Kr9UHqd8Pm3FIOHlFL_26JdK',//'X81otzGaU5tzVh0EveShCERH', // farrukh - 2
        'client_secret' => 'r1et1h_TaNqvnHtkwz9-cvy1', // Shoaib - 1
        'redirect' => '/student/login/google/callback',
    ],*/
    
    'google' => [
        'client_id'     => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect'      => env('GOOGLE_REDIRECT')
    ]
];
