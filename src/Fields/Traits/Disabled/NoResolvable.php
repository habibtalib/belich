<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Traits\Disabled;

use Daguilarm\Belich\Fields\Field;

trait NoResolvable
{
    /**
     * Disabled method the method: displayUsing
     */
    public function displayUsing(callable $displayCallback): Field
    {
        return $this;
    }

    /**
     * Disabled method the method: resolveUsing
     */
    public function resolveUsing(callable $resolveCallback): Field
    {
        return $this;
    }
}
