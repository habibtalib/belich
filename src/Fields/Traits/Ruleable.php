<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Traits;

trait Ruleable
{
    public array $rules = [];
    public array $creationRules = [];
    public array $updateRules = [];

    /**
     * Set a general rules for validation
     */
    public function rules(...$rules): self
    {
        $this->rules = $rules;
        $this->creationRules = [];
        $this->updateRules = [];

        return $this;
    }

    /**
     * Set a creation rules for validation
     */
    public function creationRules(...$rules): self
    {
        $this->creationRules = $rules;

        return $this;
    }

    /**
     * Set a update rules for validation
     */
    public function updateRules(...$rules): self
    {
        $this->updateRules = $rules;

        return $this;
    }
}
