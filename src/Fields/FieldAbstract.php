<?php

namespace Daguilarm\Belich\Fields;

abstract class FieldAbstract {

    /** @var array [List of allowed controller actions] */
    private $allowedControllerActions = [
        'index',
        'create',
        'edit',
        'show'
    ];

    /** @var string [Field help text] */
    public $help;

    /** @var bool [Indicates if the field should be sortable] */
    public $sortable = false;

    /** @var mixed [The field value (Resolved and updated...)] */
    public $value;

    /**
     * Set a help text for the field
     *
     * @param  string  $text
     * @return self
     */
    public function help(string $value = '') : self
    {
        //Check the value for conditional cases...
        if(!empty($value)) {
            $this->help = $value;
        }

        return $this;
    }

    /**
     * Set the field default value
     *
     * @param  string|null  $value
     * @return self
     */
    public function defaultValue(string $value = '') : self
    {
        //Check the value for conditional cases...
        if(!is_null($value)) {
            $this->value = $value;
        }

        return $this;
    }

    /**
     * Set the field sortable
     *
     * @return self
     */
    public function sortable() : self
    {
        $this->sortable = true;

        return $this;
    }
}
