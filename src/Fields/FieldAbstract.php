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

    /** @var array [Generate de data attributes] */
    public $data;

    /** @var bool [Disabled field] */
    public $disabled = false;

    /** @var string [Field help text] */
    public $help;

    /** @var mixed [The field value (Resolved and updated...)] */
    public $value;

    /** @var bool [Read only field] */
    public $readonly = false;

    /** @var bool [Indicates if the field should be sortable] */
    public $sortable = false;

    /**
     * Set the data attribute
     *
     * @return self
     */
    public function data($attribute, $value) : self
    {
        $this->data[] = [$attribute, $value];

        return $this;
    }

    /**
     * Set the field with the attribute 'disabled'
     *
     * @return self
     */
    public function disabled() : self
    {
        $this->disabled = true;

        return $this;
    }

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
     * Set the field with the attribute 'readonly'
     *
     * @return self
     */
    public function readOnly() : self
    {
        $this->readonly = true;

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
