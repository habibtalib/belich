<?php

namespace Daguilarm\Belich\Fields\Traits;

trait Ruleable {

    /** @var array [The validation rules for creation and updates] */
    public $rules;

    /** @var array [The validation rules for creation] */
    public $creationRules;

    /** @var array [The validation rules for updates] */
    public $updateRules;

    /**
     * Set a general rules for validation
     *
     * @param  array  $rules
     * @return self
     */
    public function rules(...$rules) : self
    {
        $this->rules         = $rules;
        $this->creationRules = null;
        $this->updateRules   = null;

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
        $this->updateRules = $rules;

        return $this;
    }
}
