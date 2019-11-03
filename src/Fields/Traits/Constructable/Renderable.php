<?php

namespace Daguilarm\Belich\Fields\Traits\Constructable;

use Daguilarm\Belich\Fields\Field;
use Illuminate\Support\Collection;

trait Renderable
{
    /**
     * Render attributes for field
     *
     * @param array $field
     * @return Illuminate\Support\Collection
     */
    private function setRenderFieldAttributes($field) : Collection
    {
        collect($field)
            ->each(function($value, $attribute) use ($field) : void {
                //Get the list of attributes to be rendered: name, dusk,...
                if(in_array($attribute, $field->renderAttributes)) {
                    //Remove attributes from list
                    if(!in_array($attribute, $field->removedAttr)) {
                        $field->render[] = sprintf('%s=%s', $attribute, $value);
                    }
                }
            })
            ->filter();

        return collect($field->render);
    }

    /**
     * Render data attributes for field
     *
     * @param array $field
     * @return string
     */
    private function setRenderFieldAttributesData($field) : string
    {
        return collect($field->data)
            ->map(function($value) {
                return sprintf('data-%s=%s', $value[0], $value[1]);
            })
            ->implode(' ');
    }

    /**
     * Render each field value
     *
     * @param array $field
     * @return Daguilarm\Belich\Fields\Field
     */
    private function renderField($field) : Field
    {
        $field->render = $field->render->implode(' ');

        return $field;
    }
}
