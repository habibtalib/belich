<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Resolves\Handler;

use Closure;

final class FieldsPrepare
{
    /**
     * Prepare the fields for resolving...
     */
    public function handle(object $fields, Closure $next): object
    {
        return $next($fields->flatten());
    }
}
