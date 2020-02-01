<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Traits\Disabled;

use Daguilarm\Belich\Fields\Field;

trait NoDuskable
{
    /**
     * Disabled method
     * Disabled the attribute: dusk
     */
    public function dusk($value = null): Field
    {
        return $this;
    }
}
