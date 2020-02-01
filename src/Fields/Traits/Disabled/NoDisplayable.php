<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Traits\Disabled;

use Daguilarm\Belich\Fields\Field;

trait NoDisplayable
{
    /**
     * Disabled method the method: displayUsing
     */
    public function displayUsing(callable $displayCallback): Field
    {
        return $this;
    }
}
