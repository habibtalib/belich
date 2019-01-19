<?php

namespace Daguilarm\Belich;

use Illuminate\Support\Facades\Facade;

class BelichFacade extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'Belich';
    }
}
