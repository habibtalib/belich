<?php

namespace Daguilarm\Belich\Fields\Traits;

trait Conditionable
{
    /**
     * @var string
     */
    public $dependsOn;

    /**
     * @var bool|null
     */
    public $dependsOnValue;
}
