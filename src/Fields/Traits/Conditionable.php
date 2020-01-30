<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Traits;

trait Conditionable
{
    public string $dependsOn = '';
    public ?bool $dependsOnValue;
}
