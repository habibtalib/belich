<?php

namespace Daguilarm\Belich\Fields\Traits\Constructable;

use Daguilarm\Belich\Fields\Field;

trait Booleanable {

    /**
     * Resolve the boolean fields
     *
     * @param  Daguilarm\Belich\Fields\Field $field
     * @param  mixed $value
     * @return mixed
     */
    protected function resolveBoolean(Field $field, $value)
    {
        // If boolean
        if($field->type === 'boolean') {

            // With default labels
            if(isset($field->trueValue) && isset($field->falseValue)) {
                return $value ? $field->trueValue : $field->falseValue;

            // With color circles
            } else {
                return sprintf('<i class="fas fa-circle text-%s-500"></i>', $value ? 'green' : 'grey');
            }
        }

        return $value;
    }
}
