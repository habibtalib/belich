<?php

namespace Daguilarm\Belich\Fields\Traits;

trait Rules {

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
     * Set a general rules for validation
     *
     * @param  array  $rules
     * @return void
     */
    public function rules(...$rules)
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
     * @return void
     */
    public function creationRules(...$rules)
    {
        //Check the text for conditional cases...
        $this->creationRules = $rules;

        return $this;
    }

    /**
     * Set a update rules for validation
     *
     * @param  array  $rules
     * @return void
     */
    public function updateRules(...$rules)
    {
        //Check the text for conditional cases...
        $this->updateRules = $rules;

        return $this;
    }
}
