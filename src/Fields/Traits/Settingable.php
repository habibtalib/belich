<?php

namespace Daguilarm\Belich\Fields\Traits;

use Daguilarm\Belich\Fields\Traits\Filterable;

trait Settingable
{
    use Filterable;

    /** @var string [Set the dusk value] */
    public $dusk;

    /** @var string [Set attribute id] */
    public $id;

    /** @var string [Set attribute name] */
    public $name;

    /**
     * Set the attribute dusk
     *
     * @param  string|null  $value
     *
     * @return self
     */
    public function dusk($value = null): self
    {
        //Check the value for conditional cases...
        if (isset($value)) {
            $this->dusk = $value;
        }

        return $this;
    }

    /**
     * Set the attribute id
     *
     * @param  string|null  $value
     *
     * @return self
     */
    public function id($value = null): self
    {
        //Check the value for conditional cases...
        if (isset($value)) {
            $this->id = $this->stringSanitizeForPhpStructure($value);
        }

        return $this;
    }

    /**
     * Set the attribute name
     *
     * @param  string|null  $value
     *
     * @return self
     */
    public function name($value = null): self
    {
        //Check the value for conditional cases...
        if (isset($value)) {
            $this->name = $value;
        }

        return $this;
    }
}
