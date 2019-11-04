<?php

namespace Daguilarm\Belich\Facades;

use Illuminate\Support\Facades\Facade;

final class Belich extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Belich';
    }
}
