<?php

namespace Daguilarm\Belich\Fields\Traits\ResolveIndex;

use Daguilarm\Belich\Facades\Helper;
use Daguilarm\Belich\Fields\Field;

trait Resolvable
{
    /**
     * Resolve field values for: relationship, displayUsing and resolveUsing
     * This method is used throw Belich Facade => Belich::html()->resolveField($field, $data);
     * This method is for refactoring the blade templates.
     *
     * @param  Daguilarm\Belich\Fields\Field $attribute
     * @param  object $data
     *
     * @return string|null
     */
    public function resolve(Field $field, ?object $data = null): ?string
    {
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
            return $this->resolveFile($field, $value);
        }

        //Resolve the field value through callbacks
        return $this->getCallbackValue($field, $data, $value);
    }

    /**
     * Resolve field values for: relationship
     * This method is helper for $this->resolve()
     *
     * @param  Daguilarm\Belich\Fields\Field $field
     * @param object $data
     * @param  string|null $value
     *
     * @return string|null
     */
    private function resolveValue(Field $field, ?object $data, ?string $value): ?string
    {
        //Resolve using labels
        $value = $this->resolveUsingLabels($field, $value);

        //Resolve Relationship
        return isset($data)
            ? $this->resolveRelationship($field, $data)
            : $value;
    }

    /**
     * Resolve boolean fields
     * This method is helper for $this->resolve()
     *
     * @param  Daguilarm\Belich\Fields\Field $field
     * @param  mixed $value
     *
     * @return string|null
     */
    private function resolveBoolean(Field $field, $value): ?string
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
     * Resolve using labels
     *
     * @param  Daguilarm\Belich\Fields\Field $field
     * @param  mixed $value
     *
     * @return string|null
     */
    private function resolveUsingLabels(Field $field, $value): ?string
    {
        return isset($field->displayUsingLabels) && isset($field->options) && isset($value)
            ? $field->options[$value]
            : $value;
    }

    /**
     * Resolve field values for: relationship
     * This method is helper for $this->resolve()
     *
     * @param  Daguilarm\Belich\Fields\Field $field
     * @param  object|null $data
     *
     * @return string|null
     */
    private function resolveRelationship(Field $field, ?object $data): ?string
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
