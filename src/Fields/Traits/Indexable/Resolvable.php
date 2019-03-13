<?php

namespace Daguilarm\Belich\Fields\Traits\Indexable;

use Daguilarm\Belich\Fields\Field;
use Illuminate\Support\Collection;

trait Resolvable {

    /**
     * Resolve field values for: relationship, displayUsing and resolveUsing
     * This method is used throw Belich Facade => Belich::html()->resolveField($field, $data);
     * This method is for refactoring the blade templates.
     *
     * @param  Daguilarm\Belich\Fields\Field $attribute
     * @param  object $data
     * @return null|string
     */
    protected function resolve(Field $field, object $data = null)
    {
        //Resolve Relationship
        if(is_array($field->attribute) && count($field->attribute) === 2 && !empty($data)) {
            $relationship = $data->{$field->attribute[0]};
            $value = optional($relationship)->{$field->attribute[1]} ?? emptyResults();

        //Resolve value for action controller: edit
        } elseif(!empty($data)) {
            $value = $data->{$field->attribute} ?? emptyResults();

        //Resolve value for action controller: show
        } else {
            $value = $field->value;
        }

        //File field
        if($field->type === 'file' && $value) {
            return $this->resolveFile($field, $value);
        }

        //Boolean custom labels
        $value = $this->resolveBoolean($field, $value);

        //Display using labels
        if(!empty($field->displayUsingLabels) && !empty($field->options)) {
            $value = $field->options[$value] ?? $value;
        }

        //Resolve the field value through callbacks
        return $this->getCallbackValue($field, $data, $value);
    }
}
