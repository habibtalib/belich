<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Traits;

trait Multiplable
{
    /**
     * Allow multiple fields with coma separate
     */
    public function multiple(): self
    {
        $this->multiple = true;

        return $this;
    }
}
