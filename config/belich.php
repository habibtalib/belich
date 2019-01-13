<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application settings
    |--------------------------------------------------------------------------
    */
    'name' => 'Belich', //Application name
    'path' => '/dashboard', //This is the URI path where application will be accessible from
    'url'  => env('APP_URL', '/'), //Application url

    /*
    |--------------------------------------------------------------------------
    | Layout options
    |--------------------------------------------------------------------------
    */
    'navbar'  => true,
    'sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | Route Middleware
    |--------------------------------------------------------------------------
    |
    | These middleware will be assigned to every dashboard route by default.
    |
    */
    'middleware' => [
        'web',
    ],
    // 'middleware' => [
    //     'web',
    //     'auth',
    //     'https',
    // ],
];
