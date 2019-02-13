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

    //Fontawesome
    'fontAwesome' => true,

    /*
    |--------------------------------------------------------------------------
    | Navbar options
    | Options: 'top' or 'full'
    |--------------------------------------------------------------------------
    */
    'navbar'  => 'top',

    /*
    |--------------------------------------------------------------------------
    | Route Middleware
    |--------------------------------------------------------------------------
    |
    | These middleware will be assigned to every dashboard route by default.
    |
    */
    'middleware' => [
        'https',
        'web',
        'auth',
    ],
];
