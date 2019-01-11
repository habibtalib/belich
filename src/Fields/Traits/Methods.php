<?php

namespace Daguilarm\Belich\Fields\Traits;

trait Methods {

    /**
     * Help text
     *
     * @var string
     */
    public $help;

    /**
     * The field's resolved value.
     *
     * @var mixed
     */
    public $value;

    /**
     * Set a help text for the field
     *
     * @param  string  $text
     * @return void
     */
    public function help($text = null)
    {
        //Check the text for conditional cases...
        if(!empty($text)) {
            $this->help = $text;
        }

        return $this;
    }

    /**
     * Set the field default value
     *
     * @param  string|null  $value
     * @return void
     */
    public function defaultValue($value = null) {
        //Check the value for conditional cases...
        if(!is_null($value)) {
            $this->value = $value;
        }

        return $this;
    }
}
