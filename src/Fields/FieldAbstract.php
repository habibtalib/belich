<?php

namespace Daguilarm\Belich\Fields;

use Illuminate\Support\Str;

abstract class FieldAbstract {

    /**
     * Help text
     *
     * @var string
     */
    public $help;

    /**
     * The field value (Resolved and updated...).
     *
     * @var mixed
     */
    public $value;

    /**
     * The validation rules for creation and updates.
     *
     * @var array
     */
    public $rules;

    /**
     * The validation rules for creation.
     *
     * @var array
     */
    public $creationRules;

    /**
     * The validation rules for updates.
     *
     * @var array
     */
    public $updateRules;

    /**
     * Field visibility base on the action
     *
     * @var array
     */
    public $showOn = [
        'index' => true,
        'create' => true,
        'edit' => true,
        'show' => true
    ];

    /**
     * List of allowed actions
     *
     * @var array
     */
    private $alowedActions = ['index', 'create', 'edit', 'show'];

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
        $this->showOn['index'] = false;

        return $this;
    }

    /**
     * Hide field when show a resource
     *
     * @var self
     */
    public function hideFromDetail() : self
    {
        $this->showOn['show'] = false;

        return $this;
    }

    /**
     * Hide field when creating a resource
     *
     * @var self
     */
    public function hideWhenCreating() : self
    {
        $this->showOn['create'] = false;

        return $this;
    }

    /**
     * Hide field when updating a resource
     *
     * @var self
     */
    public function hideWhenUpdating() : self
    {
        $this->showOn['edit'] = false;

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

        $this->showOn['index'] = true;
        $this->showOn['show'] = true;

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

        $this->showOn['create'] = true;
        $this->showOn['edit'] = true;

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

        $this->showOn['index'] = true;

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

        $this->showOn['show'] = true;

        return $this;
    }

    /**
     * Show field only on...
     *
     * @var self
     */
    public function showOn(...$attributes) : self
    {
        //Reset the values
        self::hideAllActions();

        foreach($attributes as $attribute) {
            if(in_array($attribute, $this->alowedActions)) {
                $this->showOn[$attribute] = true;
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
            $this->showOn[$attribute] = false;
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
        foreach($this->showOn as $attribute => $value) {
            $this->showOn[$attribute] = false;
        }
    }
}
