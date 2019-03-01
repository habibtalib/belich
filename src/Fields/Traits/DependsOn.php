<?php

namespace Daguilarm\Belich\Fields\Traits;

use Daguilarm\Belich\Fields\Field;

trait DependsOn {

    /** @var bool|null */
    public $dependOnCondition;

    /** @var \Closure|null */
    public $dependOn;

    /** @var string */
    public $dependOnField;

    /**
     * Set the condition for dependency
     *
     * @return self
     */
    public function dependOnCondition($condition) : self
    {
        $this->dependOnCondition = $condition;

        return $this;
    }

    /**
     * Set the Fields callback for the condition
     *
     * @return self
     */
    public function dependOn(string $field, callable $callback) : self
    {
        if(!empty($callback)) {
            $this->dependOn      = $callback;
            $this->dependOnField = $field;
        }

        return $this;
    }

    /**
     * Render the Fields dependencies if...
     *
     * @param array $fields
     * @return self
     */
    protected function dependencies($fields) : array
    {
        return $fields->map(function($field) use ($fields) {
            //If the field has dependency
            if($field->dependOn) {
                $parentField = $fields->where('attribute', $field->dependOnField);
                //If results
                if($parentField->count() > 0 && $parentField->first()->value) {
                    return call_user_func($field->dependOn);
                }
            }
        })
        ->filter()
        ->first() ?? [];
    }
}
