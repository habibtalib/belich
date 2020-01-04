<?php

namespace Daguilarm\Belich\Fields\Resolves\Handler\Types;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;
use Daguilarm\Belich\Facades\Helper;

final class Currency implements HandleField
{
    /**
     * Handle color field
     *
     * @param object $field
     * @param Closure $next
     *
     * @return object
     */
    public function handle(object $field, Closure $next): object
    {
        // Resolve currency fields
        if (isset($field->subType) && $field->subType === 'currency') {
            // Format the money
            $field->value = Helper::formatMoney(
                $field->value,
                $field->currency,
                $field->locale
            );
        }

        return $next($field);
    }
}
