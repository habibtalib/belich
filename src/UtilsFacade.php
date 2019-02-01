<?php

namespace Daguilarm\Belich;

use Illuminate\Support\Facades\Facade;

class UtilsFacade extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'Utils';
    }
}
