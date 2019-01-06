<?php

$files = collect(scandir(app_path('Belich/Resources')))
    ->map(function($file) {
        return $file;
    })->filter(function($value, $key) {
        return $value !== '.' && $value !== '..';
    })->map(function($file) {
        return str_plural(strtolower(explode('.', $file)[0]));
    });

foreach($files as $route) {
    if($route) {
        Route::resource($route, 'Daguilarm\Belich\App\Http\Controllers\RestfullController')
            ->middleware(config('belich.middleware') ?? ['web', 'auth', 'https']);
    }
}

require_once(app_path('/Belich/Routes.php'));
