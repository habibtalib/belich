<?php

namespace Daguilarm\Belich\Fields\ResolveIndex;

use Daguilarm\Belich\Facades\Helper;
use Daguilarm\Belich\Fields\Field;

final class Resolve
{
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
    public function resolveValue(Field $field, ?object $data, ?string $value): ?string
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
    public function resolveBoolean(Field $field, $value): ?string
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
