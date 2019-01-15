<?php

namespace Daguilarm\Belich\Fields\Traits;

trait Settings {

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
     * @return self
     */
    public function dusk(string $value = '')
    {
        //Check the value for conditional cases...
        if(!empty($value)) {
            $this->dusk = $value;
        }

        return $this;
    }

    /**
     * Set the attribute id
     *
     * @param  string|null  $value
     * @return self
     */
    public function id(string $value = '')
    {
        //Check the value for conditional cases...
        if(!empty($value)) {
            $this->id = $value;
        }

        return $this;
    }

    /**
     * Set the attribute name
     *
     * @param  string|null  $value
     * @return self
     */
    public function name(string $value = '')
    {
        //Check the value for conditional cases...
        if(!empty($value)) {
            $this->name = $value;
        }

        return $this;
    }
}
