<?php

namespace Daguilarm\Belich\Fields\Traits\Constructable;

use Illuminate\Support\Collection;

trait Valuable
{
    /**
     * When the action is update or show
     * We have to update the field value
     *
     * @param Illuminate\Support\Collection $sqlResponse
     * @return Illuminate\Support\Collection
     */
    private function setValueForFields(object $sqlResponse, Collection $fields) : Collection
    {
        return $fields->map(function($field) use ($sqlResponse) {
            //Not resolve field value
            //Mostly, this is a hidden field...
            if($field->notResolveField) {
                return $field;
            }

            //Set new value for the fields, even if has a fieldRelationship value
            //This relationship method is only on forms
            //Index has its own way in blade template
            $field->value = self::setValuesWithFieldRelationship($sqlResponse, $field);

            //Add the data for the show view
            if($this->action === 'show') {
                //Display using labels
                if(!empty($field->displayUsingLabels) && !empty($field->options)) {
                    $field->value = $field->options[$field->value] ?? $field->value;
                }

                //Regular
                $field->data = $sqlResponse;
            }

            return $field;
        });
    }

    /**
     * Determine value with relationship if exists...
     *
     * @param Illuminate\Support\Collection $sqlResponse
     * @param Illuminate\Support\Collection $fields
     * @return Illuminate\Support\Collection
     */
    private function setValuesWithFieldRelationship(object $sqlResponse, object $field)
    {
        if($field->fieldRelationship) {
            return $sqlResponse->{$field->fieldRelationship}->{$field->attribute} ?? null;
        }

        return $sqlResponse->{$field->attribute} ?? null;
    }
}
