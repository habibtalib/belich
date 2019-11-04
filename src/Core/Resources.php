<?php

namespace Daguilarm\Belich\Core;

use Daguilarm\Belich\Core\ResourcesRepository;
use Daguilarm\Belich\Core\Traits\Modelable;
use Daguilarm\Belich\Core\Traits\Operationable;
use Daguilarm\Belich\Core\Traits\Resourceable;
use Daguilarm\Belich\Core\Traits\Routeable;
use Daguilarm\Belich\Core\Traits\Systemable;
use Illuminate\Http\Request;

abstract class Resources extends ResourcesRepository
{
    use Modelable,
        Operationable,
        Resourceable,
        Routeable,
        Systemable;

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     */
    abstract public function fields(Request $request);

    /**
     * Set the custom cards
     *
     * @param  \Illuminate\Http\Request  $request
     */
    abstract public static function cards(Request $request);

    /**
     * Set the custom metrics cards
     *
     * @param  \Illuminate\Http\Request  $request
     */
    abstract public static function metrics(Request $request);
}
