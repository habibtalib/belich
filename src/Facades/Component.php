<?php

namespace Daguilarm\Belich\Facades;

use Illuminate\Support\Facades\Facade;

class Component extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'Component';
    }
}
