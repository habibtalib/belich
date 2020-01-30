<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Resolves\Handler\Index;

use Daguilarm\Belich\Facades\Belich;

final class Callback
{
    /**
     * Resolve field value through callbacks
     */
    public function handle(object $field, ?object $data = null, ?string $value = null): ?string
    {
        // Resolve value when using the method: $field->displayUsing()
        $value = $this->displayCallback($field, $value);

        //Resolve value when using the method: $field->resolveUsing()
        return $this->resolveCallback($field, $data, $value);
    }

    /**
     * Resolve field callback: $field->displayUsing()
     */
    private function displayCallback(object $field, $value = ''): ?string
    {
        if (! isset($field->displayCallback) || $field->notDisplayUsing === true) {
            return $value;
        }

        foreach ($field->displayCallback as $callback) {
            $value = is_callable($callback) ? call_user_func($callback, $value) : null;
        }

        return $value;
    }

    /**
     * Resolve field callback: $field->resolveUsing()
     */
    private function resolveCallback(object $field, ?object $data = null, $value = ''): ?string
    {
        if (! isset($field->resolveCallback) || ! is_callable($field->resolveCallback) || $field->notResolveUsing === false) {
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
