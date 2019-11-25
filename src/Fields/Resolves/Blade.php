<?php

namespace Daguilarm\Belich\Fields\Resolves;

use Daguilarm\Belich\Facades\Helper;
use Daguilarm\Belich\Fields\Resolves\Callback;
use Daguilarm\Belich\Fields\Resolves\File;
use Daguilarm\Belich\Fields\Traits\Resolvable;

final class Blade
{
    use Resolvable;

    /**
     * Resolve field values for: relationship, displayUsing and resolveUsing
     * This method is used throw Belich Facade => Belich::value($field, $data);
     * This method is for refactoring the blade templates.
     *
     * @param  object $field
     * @param  object $data
     *
     * @return string|null
     */
    public function execute(object $field, ?object $data = null): ?string
    {
        // Resolve for relationship fields
        if ($field->type === 'relationship') {
            return $field->index($data);
        }

        //Resolve value for action controller: show
        $value = $field->value;

        //Resolve value
        $value = $this->resolveValue($field, $data, $value);

        // If boolean
        // Please respect this orden -> first $this->resolveValue($field, $data, $value)
        // then $this->resolveBoolean($field, $value)
        if ($field->type === 'boolean') {
            return $this->resolveBoolean($field, $value);
        }

        //File field
        if ($field->type === 'file') {
            return (new File())->execute($field, $value);
        }

        //TextArea field
        if ($field->type === 'textArea') {
            return $this->resolveTextArea($field, $value);
        }

        //displayUsingLabels filter
        if (isset($field->displayUsingLabels) && $field->displayUsingLabels) {
            return Helper::displayUsingLabels($field, $value);
        }

        //Resolve the field value through callbacks
        return app(Callback::class)->execute($field, $data, $value);
    }

    /**
     * Resolve field values for: relationship
     * This method is helper for $this->resolve()
     *
     * @param  object $field
     * @param object $data
     * @param  string|null $value
     *
     * @return string|null
     */
    public function resolveValue(object $field, ?object $data, ?string $value): ?string
    {
        //Resolve Relationship
        return isset($data)
            ? $this->resolveRelationship($field, $data)
            : $value;
    }

    /**
     * Resolve boolean fields
     * This method is helper for $this->resolve()
     *
     * @param  object $field
     * @param  mixed $value
     *
     * @return string|null
     */
    public function resolveBoolean(object $field, $value): ?string
    {
        // With default labels
        if (isset($field->trueValue) && isset($field->falseValue)) {
            return $value
                ? $field->trueValue
                : $field->falseValue;
        }

        // With color circles
        return sprintf('<i class="fas fa-circle text-%s-500"></i>', $value ? $field->color : 'grey');
    }

    /**
     * Resolve field values for: relationship
     * This method is helper for $this->resolve()
     *
     * @param  object $field
     * @param  object|null $data
     *
     * @return string|null
     */
    private function resolveRelationship(object $field, ?object $data): ?string
    {
        //Resolve Relationship
        if (is_array($field->attribute)) {
            $relationship = $data->{$field->attribute[0]};

            return optional($relationship)->{$field->attribute[1]} ?? Helper::emptyResults();
        }

        //Resolve value for action controller: edit
        return $data->{$field->attribute} ?? Helper::emptyResults();
    }
}
