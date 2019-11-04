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
     *
     * @return Illuminate\Support\Collection
     */
    private function setValueForFields(object $sqlResponse, Collection $fields): Collection
    {
        return $fields->map(function ($field) use ($sqlResponse) {
            //Not resolve field value
            //Mostly, this is a hidden field...
            if ($field->notResolveField) {
                return $field;
            }

            //Set new value for the fields, even if has a fieldRelationship value
            //This relationship method is only on forms
            //Index has its own way in blade template
            $field->value = $this->setValuesWithFieldRelationship($sqlResponse, $field);

            //filter the data for the show view and return the $field
            return $this->setValueForFieldsForActionShow($field, $sqlResponse);
        });
    }

    /**
     * Determine value with relationship if exists...
     *
     * @param object $sqlResponse
     * @param object $fields
     *
     * @return string|null
     */
    private function setValuesWithFieldRelationship(object $sqlResponse, object $field): ?string
    {
        if ($field->fieldRelationship) {
            return $sqlResponse->{$field->fieldRelationship}->{$field->attribute} ?? null;
        }

        return $sqlResponse->{$field->attribute} ?? null;
    }

    /**
     * Determine value for show view
     *
     * @param object $sqlResponse
     * @param object $fields
     *
     * @return string|null
     */
    private function setValueForFieldsForActionShow(object $field, object $sqlResponse): object
    {
        if ($this->action === 'show') {
            //Display using labels
            if (isset($field->displayUsingLabels) && isset($field->options)) {
                $field->value = $field->options[$field->value] ?? $field->value;
            }

            //Regular
            $field->data = $sqlResponse;
        }

        return $field;
    }
}
