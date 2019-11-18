<?php

namespace Daguilarm\Belich\Fields\Traits\Constructable;

use Daguilarm\Belich\Fields\Traits\Resolvable;
use Illuminate\Support\Collection;

trait Valuable
{
    use Resolvable;

    /**
     * When the action is update or show
     * We have to update the field value
     *
     * @param Illuminate\Support\Collection $sql
     *
     * @return Illuminate\Support\Collection
     */
    protected function valueForFields(object $sql, Collection $fields): Collection
    {
        return $fields->map(function ($field) use ($sql) {
            if ($field->type === 'relationship') {
                $field->value = $field->{$this->action}($sql);

                return $field;
            }
            //Set new value for the fields, even if has a fieldRelationship value
            //This relationship method is only on forms
            //Index has its own way in blade template
            $field->value = $this->valuesWithFieldRelationship($sql, $field);

            //filter the data for the show view and return the $field
            return $this->valueForFieldsForActionShow($field, $sql);
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
    private function valuesWithFieldRelationship(object $sql, object $field): ?string
    {
        return $field->fieldRelationship
            ? $sql->{$field->fieldRelationship}->{$field->attribute} ?? null
            : $sql->{$field->attribute} ?? null;
    }

    /**
     * Determine value for show view
     *
     * @param object $sql
     * @param object $fields
     *
     * @return string|null
     */
    private function valueForFieldsForActionShow(object $field, object $sql): object
    {
        if ($this->action === 'show') {
            //Display using labels
            if (isset($field->displayUsingLabels) && isset($field->options)) {
                $field->value = $this->displayUsingLabels($field, $field->value);
            }

            //TextArea field
            if ($field->type === 'textArea') {
                $field->value = $this->resolveTextArea($field);
            }

            //Regular field
            $field->data = $sql;
        }

        return $field;
    }
}
