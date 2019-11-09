<?php

namespace Daguilarm\Belich\Fields\Traits;

trait Helpeable
{
    /**
     * Field help text
     *
     * @var string
     */
    public $help;

    /**
     * Set a help text for the field
     *
     * @param  string  $text
     *
     * @return self
     */
    public function help($value = null): self
    {
        //Check the value for conditional cases...
        if (isset($value)) {
            $this->help = $value;
        }

        return $this;
    }
}
