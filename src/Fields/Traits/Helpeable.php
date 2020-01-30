<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Traits;

trait Helpeable
{
    public string $help;
    public string $info;

    /**
     * Set a help text for the field
     */
    public function help($value = null): self
    {
        //Check the value for conditional cases...
        if (isset($value)) {
            $this->help = $value;
        }

        return $this;
    }

    /**
     * Set a help text for the field
     */
    public function info($value = null): self
    {
        //Check the value for conditional cases...
        if (isset($value)) {
            $this->info = $value;
        }

        return $this;
    }
}
