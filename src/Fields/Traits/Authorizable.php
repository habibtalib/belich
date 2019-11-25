<?php

namespace Daguilarm\Belich\Fields\Traits;

trait Authorizable
{
    /**
     * Set the callback to be run to authorize viewing the field.
     *
     * @param  \Closure  $callback
     *
     * @return self
     */
    public function canSee(\Closure $callback): self
    {
        $this->seeCallback = $callback;

        return $this;
    }
}
