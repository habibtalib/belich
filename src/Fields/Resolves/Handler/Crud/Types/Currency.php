<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Resolves\Handler\Crud\Types;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;
use Daguilarm\Belich\Facades\Helper;

final class Currency implements HandleField
{
    /**
     * Handle color field
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
