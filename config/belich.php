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
    | Application URL
    |--------------------------------------------------------------------------
    |
    | Set the application URL. You can change this value as your request.
    */
    'url' => env('APP_URL', '/'),

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
