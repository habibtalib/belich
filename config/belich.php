<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application settings
    |--------------------------------------------------------------------------
    */

    //Application name
    'name' => 'Belich Dashboard',

    //This is the URI path where application will be accessible from
    'path' => '/dashboard',

    //Application url
    'url'  => env('APP_URL', '/'),

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
