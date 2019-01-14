<?php

namespace Daguilarm\Belich\Fields;

abstract class FieldAbstract {

    /** @var array [The validation rules for creation and updates] */
    public $rules;

    /** @var array [The validation rules for creation] */
    public $creationRules;

    /** @var array [The validation rules for updates] */
    public $updateRules;

    /////////////////////

    /** @var array [List of allowed controller actions] */
    private $alowedControllerActions = ['index', 'create', 'edit', 'show'];

    /** @var string [Field help text] */
    public $help;

    /** @var mixed [The field value (Resolved and updated...)] */
    public $value;

    /** @var array [Field visibility base on the action] */
    public $visibility = [
        'index' => true,
        'create' => true,
        'edit' => true,
        'show' => true
    ];

    /*
    |--------------------------------------------------------------------------
    | Groups: general options
    |--------------------------------------------------------------------------
    */

    /**
     * Set a help text for the field
     *
     * @param  string  $text
     * @return self
     */
    public function help($text = null) : self
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

    /*
    |--------------------------------------------------------------------------
    | Groups: validation and rules
    |--------------------------------------------------------------------------
    */

    /**
     * Set a general rules for validation
     *
     * @param  array  $rules
     * @return self
     */
    public function rules(...$rules) : self
    {
        //Check the text for conditional cases...
        $this->rules = $rules;
        $this->creationRules = null;
        $this->updateRules = null;

        return $this;
    }

    /**
     * Set a creation rules for validation
     *
     * @param  array  $rules
     * @return self
     */
    public function creationRules(...$rules) : self
    {
        //Check the text for conditional cases...
        $this->creationRules = $rules;

        return $this;
    }

    /**
     * Set a update rules for validation
     *
     * @param  array  $rules
     * @return self
     */
    public function updateRules(...$rules) : self
    {
        //Check the text for conditional cases...
        $this->updateRules = $rules;

        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Groups: visibility
    |--------------------------------------------------------------------------
    */

    /**
     * Hide field from index
     *
     * @var self
     */
    public function hideFromIndex() : self
    {
        $this->visibility['index'] = false;

        return $this;
    }

    /**
     * Hide field when show a resource
     *
     * @var self
     */
    public function hideFromDetail() : self
    {
        $this->visibility['show'] = false;

        return $this;
    }

    /**
     * Hide field when creating a resource
     *
     * @var self
     */
    public function hideWhenCreating() : self
    {
        $this->visibility['create'] = false;

        return $this;
    }

    /**
     * Hide field when updating a resource
     *
     * @var self
     */
    public function hideWhenUpdating() : self
    {
        $this->visibility['edit'] = false;

        return $this;
    }

    /**
     * Hide field when creating or updating a resource
     *
     * @var self
     */
    public function exceptOnForms() : self
    {
        //Reset the values
        self::hideAllActions();

        $this->visibility['index'] = true;
        $this->visibility['show'] = true;

        return $this;
    }

    /**
     * Show field only when creating or updating a resource
     *
     * @var self
     */
    public function onlyOnForms() : self
    {
        //Reset the values
        self::hideAllActions();

        $this->visibility['create'] = true;
        $this->visibility['edit'] = true;

        return $this;
    }

    /**
     * Show field only on index
     *
     * @var self
     */
    public function onlyOnIndex() : self
    {
        //Reset the values
        self::hideAllActions();

        $this->visibility['index'] = true;

        return $this;
    }

    /**
     * Show field only on detail
     *
     * @var self
     */
    public function onlyOnDetail() : self
    {
        //Reset the values
        self::hideAllActions();

        $this->visibility['show'] = true;

        return $this;
    }

    /**
     * Show field only on...
     *
     * @var self
     */
    public function visibility(...$attributes) : self
    {
        //Reset the values
        self::hideAllActions();

        foreach($attributes as $attribute) {
            if(in_array($attribute, $this->alowedControllerActions)) {
                $this->visibility[$attribute] = true;
            }
        }

        return $this;
    }

    /**
     * Hide field only from...
     *
     * @var self
     */
    public function hideFrom(...$attributes) : self
    {
        foreach($attributes as $attribute) {
            $this->visibility[$attribute] = false;
        }

        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Groups: helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Hide field for all actions
     *
     * @var void
     */
    private function hideAllActions()
    {
        foreach($this->visibility as $attribute => $value) {
            $this->visibility[$attribute] = false;
        }
    }
}
