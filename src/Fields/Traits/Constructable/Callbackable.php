<?php

namespace Daguilarm\Belich\Fields\Traits\Constructable;

use Daguilarm\Belich\Facades\Belich;
use Daguilarm\Belich\Fields\Field;

trait Callbackable
{
    /**
     * Resolve field value through callbacks
     *
     * @param Daguilarm\Belich\Fields\Field $field
     * @param object $data
     * @param string|null $value
     *
     * @return string|null
     */
    protected function getCallbackValue(Field $field, ?object $data = null, $value = ''): ?string
    {
        //Resolve value when using the method: $field->displayUsing()
        $value = $this->displayCallback($field, $value);

        //Resolve value when using the method: $field->resolveUsing()
        return $this->resolveCallback($field, $data, $value);
    }

    /**
     * Resolve field callback: $field->displayUsing()
     *
     * @param Daguilarm\Belich\Fields\Field $field
     * @param string|null $value
     *
     * @return string|null
     */
    private function displayCallback(Field $field, $value = ''): ?string
    {
        if (!isset($field->displayCallback) || $field->notDisplayUsing === true) {
            return $value;
        }

        foreach ($field->displayCallback as $callback) {
            $value = is_callable($callback) ? call_user_func($callback, $value) : null;
        }

        return $value;
    }

    /**
     * Resolve field callback: $field->resolveUsing()
     *
     * @param Daguilarm\Belich\Fields\Field $field
     * @param object $data
     * @param string|null $value
     *
     * @return string|null
     */
    private function resolveCallback(Field $field, ?object $data = null, $value = ''): ?string
    {
        if (!is_callable($field->resolveCallback) || $field->notResolveUsing === false) {
            return $value;
        }

        //Resolve value when using the method: $field->resolveUsing()
        //Add the data for the show view
        //No need to resolve for index because the $data variable is already available
        $data = Belich::action() === 'show'
            ? $field->data
            : $data;

        return call_user_func($field->resolveCallback, $data);
    }
}
