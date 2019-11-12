<?php

namespace Daguilarm\Belich\Fields\ResolveIndex;

use Daguilarm\Belich\Facades\Helper;
use Daguilarm\Belich\Fields\Field;
use Daguilarm\Belich\Fields\Traits\Resolvable;

final class Resolve
{
    use Resolvable;

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
