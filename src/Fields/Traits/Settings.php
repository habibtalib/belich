<?php

namespace Daguilarm\Belich\Fields\Traits;

trait Settings {

    /** @var string [Set field id] */
    public $id;

    /** @var string [Set field name] */
    public $name;

    /**
     * Set the field id
     *
     * @param  string|null  $value
     * @return self
     */
    public function id($value = null)
    {
        //Check the value for conditional cases...
        if(!empty($value)) {
            $this->id = $value;
        }

        return $this;
    }

    /**
     * Set the field name
     *
     * @param  string|null  $value
     * @return self
     */
    public function name($value = null)
    {
        //Check the value for conditional cases...
        if(!empty($value)) {
            $this->name = $value;
        }

        return $this;
    }
}
