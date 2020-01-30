<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Traits;

trait Authorizable
{
    /**
     * Set the callback to be run to authorize viewing the field.
     */
    public function canSee(\Closure $callback): self
    {
        $this->seeCallback = $callback;

        return $this;
    }
}
