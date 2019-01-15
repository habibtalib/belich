<?php

namespace Daguilarm\Belich\Fields\Traits;

trait Render {

    /** @var string [Render all the field attributes] */
    public $render;

    /**
    * Render the field attributes
    *
    * @param array $attributes
    * @return
    */
    private function renderFieldAttributes(...$attributes)
    {
        if($this->fieldHasRelationship($this->attribute)) {
            return sprintf('readonly');
        }

        return collect($attributes)->map(function($attribute) {
            return sprintf('%s=%s', $attribute, $this->{$attribute});
        })
        ->implode(' ');
    }
}
