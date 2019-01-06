<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application.
    */
    'name' => 'Belich',

    /*
    |--------------------------------------------------------------------------
    | Application path
    |--------------------------------------------------------------------------
    |
    | This is the URI path where application will be accessible from.
    */
    'path' => '/dashboard',

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
        'auth',
        'https'
    ],
];
