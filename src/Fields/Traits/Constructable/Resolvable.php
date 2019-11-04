<?php

namespace Daguilarm\Belich\Fields\Traits\Constructable;

use Daguilarm\Belich\Facades\Helper;
use Daguilarm\Belich\Fields\Field;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

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
     * @return null|string
     */
    public function resolve(Field $field, object $data = null): ?string
    {
        //Resolve value for action controller: show
        $value = $field->value;

        //File field
        if ($field->type === 'file' && $value) {
            return $this->resolveFile($field, $value);
        }

        //Resolve value
        $value = $this->resolveValue($field, $data, $value);

        //Resolve the field value through callbacks
        return $this->getCallbackValue($field, $data, $value);
    }

    /**
     * Resolve field values for: relationship
     * This method is helper for $this->resolve()
     *
     * @param  Daguilarm\Belich\Fields\Field $field
     * @param object $data
     * @param  null|string $value
     *
     * @return null|string
     */
    private function resolveValue(Field $field, ?object $data, ?string $value): ?string
    {
        //Boolean custom labels
        $value = $this->resolveBoolean($field, $value);

        //Resolve using labels
        $value = $this->resolveUsingLabels($field, $value);

        //Resolve Relationship
        return isset($data)
            ? $this->resolveRelationship($field, $data)
            : $value;
    }

    /**
     * Resolve the boolean fields
     *
     * @param  Daguilarm\Belich\Fields\Field $field
     * @param  mixed $value
     *
     * @return mixed
     */
    private function resolveBoolean(Field $field, $value)
    {
        // If boolean
        if ($field->type === 'boolean') {
            // With default labels
            if (isset($field->trueValue) && isset($field->falseValue)) {
                return $value ? $field->trueValue : $field->falseValue;
            }

            // With color circles
            return sprintf('<i class="fas fa-circle text-%s-500"></i>', $value ? 'green' : 'grey');
        }

        return $value;
    }

    /**
     * Resolve using labels
     *
     * @param  Daguilarm\Belich\Fields\Field $field
     * @param  mixed $value
     *
     * @return null|string
     */
    protected function resolveUsingLabels(Field $field, $value): ?string
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
     * @param  null|object $data
     *
     * @return null|string
     */
    private function resolveRelationship(Field $field, ?object $data): ?string
    {
        //Resolve Relationship
        if (is_array($field->attribute)) {
            $relationship = $data->{$field->attribute[0]};

            return optional($relationship)->{$field->attribute[1]} ?? Helper::emptyResults();
        }

        //Resolve value for action controller: edit
        $resolveForActionControllerEdit = $data->{$field->attribute} ?? Helper::emptyResults();

        return $value ?? $resolveForActionControllerEdit;
    }
}
