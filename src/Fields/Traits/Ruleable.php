<?php

namespace Daguilarm\Belich\Fields\Traits;

trait Ruleable
{
    /**
     * The validation rules for creation and updates
     *
     * @var array
     */
    public $rules;

    /**
     * The validation rules for creation
     *
     * @var array
     */
    public $creationRules;

    /**
     * The validation rules for updates
     *
     * @var array
     */
    public $updateRules;

    /**
     * Set a general rules for validation
     *
     * @param  array  $rules
     *
     * @return self
     */
    public function rules(...$rules): self
    {
        $this->rules = $rules;
        $this->creationRules = null;
        $this->updateRules = null;

        return $this;
    }

    /**
     * Set a creation rules for validation
     *
     * @param  array  $rules
     *
     * @return self
     */
    public function creationRules(...$rules): self
    {
        $this->creationRules = $rules;

        return $this;
    }

    /**
     * Set a update rules for validation
     *
     * @param  array  $rules
     *
     * @return self
     */
    public function updateRules(...$rules): self
    {
        $this->updateRules = $rules;

        return $this;
    }
}
