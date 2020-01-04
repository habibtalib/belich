<?php

namespace Daguilarm\Belich\Fields\Resolves;

use Daguilarm\Belich\Facades\Belich;
use Daguilarm\Belich\Facades\Helper;
use Daguilarm\Belich\Fields\Traits\Resolvable;
use Illuminate\Support\Collection;

final class ResolveCrudValue
{
    use Resolvable;

    /**
     * @var string
     */
    private $action;

    /**
     * Init constructor
     */
    public function __construct()
    {
        $this->action = Belich::action();
    }

    /**
     * When the action is update or show
     * We have to update the field value
     *
     * @param Illuminate\Support\Collection $sql
     *
     * @return Illuminate\Support\Collection
     */
    public function execute(Collection $fields, object $sql): Collection
    {
        return $fields->map(function ($field) use ($sql) {
            //Set new value for the fields, even if has a fieldRelationship value
            //This relationship method is only on forms
            //Index has its own way in blade template
            $field->value = $this->resolveValue($sql, $field);

            // Resolve relationship
            if ($field->type === 'relationship') {
                return $this->resolveRelationship($field, $sql);
            }

            //filter the data for the show view or return the $field
            return $this->actionShow($field, $sql);
        });
    }

    /**
     * Resolve value even if it has a relationship (if exists...)
     *
     * @param object $sql
     * @param object $fields
     *
     * @return string|null
     */
    private function resolveValue(object $sql, object $field): ?string
    {
        // If relationship...
        if ($field->type === 'relationship' && $field->fieldRelationship) {
            $field->valueRelationship = $sql->{$field->fieldRelationship}->id ?? null;
        }

        return $field->fieldRelationship
            ? $sql->{$field->fieldRelationship}->{$field->attribute} ?? null
            : $sql->{$field->attribute} ?? null;
    }

    /**
     * Resolve relationship
     *
     * @param object $fields
     * @param object $sql
     *
     * @return string|null
     */
    private function resolveRelationship(object $field, object $sql)
    {
        return $this->action !== 'edit'
            ? $field->{$this->action}($field, $sql)
            : $field;
    }

    /**
     * Determine value for show view
     *
     * @param object $sql
     * @param object $fields
     *
     * @return string|null
     */
    private function actionShow(object $field, object $sql): object
    {
        if ($this->action !== 'show') {
            return $field;
        }

        // Resolve show view for custom field
        if ($field->type === 'custom') {
            // Set value
            $field->value = $field->show($field, $sql);

            return $field;
        }

        //Display using labels
        if (isset($field->displayUsingLabels) && isset($field->options)) {
            $field->value = Helper::displayUsingLabels($field, $field->value);
        }

        //TextArea field
        if ($field->type === 'textArea' || $field->type === 'markdown') {
            $field->value = $this->resolveTextArea($field);
        }

        // Resolve show view for custom field
        if ($field->type === 'color' && isset($field->asColor) && $field->asColor === true) {
            // Set value
            $field->asHtml()->value = sprintf(
                '<div class="w-12 h-2 rounded" style="background-color:%s">&nbsp;</div>',
                $field->value
            );

            return $field;
        }

        // Currency fields
        if(isset($field->subType) && $field->subType === 'currency') {
            // Format the money
            $field->value = Helper::formatMoney($field->value, $field->currency, $field->locale);
        }

        //Regular field
        $field->data = $sql;

        return $field;
    }
}
