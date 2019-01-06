<?php

namespace Daguilarm\Belich\Routes;

class GenerateRoutes {

    private function generateRoutesFromResources() {
        return collect($attributes)->map(function($route) {
            Route::resource($route, 'PhotoController');
        });
    }
}
