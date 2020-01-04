<?php

namespace Daguilarm\Belich\Fields\Resolves\Handler\Crud\Types;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;
use Daguilarm\Belich\Facades\Helper;

final class Select implements HandleField
{
    /**
     * Handle the relationship value
     *
     * @param object $field
     * @param Closure $next
     *
     * @return object
     */
    public function handle(object $field, Closure $next): object
    {
        //Resolve using Display Using Labels
        if (isset($field->displayUsingLabels) && isset($field->options)) {
            $field->value = Helper::displayUsingLabels($field, $field->value);
        }

        return $next($field);
    }
}
