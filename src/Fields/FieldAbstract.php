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

    /**
     * By default, the regular fields like: text, select,... cannot operate with relationships
     * When a regular field has a belongTo or hasOne relationship, the field will has the attribute readOnly
     * Other relationships will return an empty field
     *
     * @var bool
     */
    public $renderRelationships = false;

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
    public function help($value = null) : self
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
    public function defaultValue($value = null) : self
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
