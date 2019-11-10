<?php

namespace Daguilarm\Belich\Fields\Traits\Constructable;

use Illuminate\Support\Collection;

trait Valuable
{
    /**
     * When the action is update or show
     * We have to update the field value
     *
     * @param Illuminate\Support\Collection $sql
     *
     * @return Illuminate\Support\Collection
     */
    protected function setValueForFields(object $sql, Collection $fields): Collection
    {
        return $fields->map(function ($field) use ($sql) {
            //Set new value for the fields, even if has a fieldRelationship value
            //This relationship method is only on forms
            //Index has its own way in blade template
            $field->value = $this->setValuesWithFieldRelationship($sql, $field);

            //filter the data for the show view and return the $field
            return $this->setValueForFieldsForActionShow($field, $sql);
        });
    }

    /**
     * Determine value with relationship if exists...
     *
     * @param object $sql
     * @param object $fields
     *
     * @return string|null
     */
    private function setValuesWithFieldRelationship(object $sql, object $field): ?string
    {
        if ($field->fieldRelationship) {
            return $sql->{$field->fieldRelationship}->{$field->attribute} ?? null;
        }

        return $sql->{$field->attribute} ?? null;
    }

    /**
     * Determine value for show view
     *
     * @param object $sql
     * @param object $fields
     *
     * @return string|null
     */
    private function setValueForFieldsForActionShow(object $field, object $sql): object
    {
        if ($this->action === 'show') {
            //Display using labels
            if (isset($field->displayUsingLabels) && isset($field->options)) {
                $field->value = $field->options[$field->value] ?? $field->value;
            }

            //Regular
            $field->data = $sql;
        }

        return $field;
    }
}
