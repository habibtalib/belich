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
    | Navbar options
    | Options: 'top' or 'sidebar'
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

    /*
    |--------------------------------------------------------------------------
    | Export file (xls, xlsx, csv) from supported drivers
    |--------------------------------------------------------------------------
    |
    | Belich has support for:
    |
    | @Driver: Fast Excel
    | @Github: https://github.com/rap2hpoutre/fast-excel
    | @value: 'fast-excel'
    |
    | @Driver: Laravel Maatwebsite excel (comming soon...)
    | @Github: https://laravel-excel.maatwebsite.nl/
    | @value: 'maatwebsite'
    |
    */
    'export' => [
        'driver' => 'fast-excel',
    ],

    /*
    |--------------------------------------------------------------------------
    | Url allowed parameters
    |--------------------------------------------------------------------------
    |
    | Belich only allows a list of predetermined parameters. If you need your own url
    | parameters, please, add this to this variable...
    |
    */
    'allowedUrlParameters' => [],

    /*
    |--------------------------------------------------------------------------
    | Minify html
    |--------------------------------------------------------------------------
    |
    | Belich will minify the html before blade create the cache for the views
    |
    */
    'minifyHtml' => true,
];
