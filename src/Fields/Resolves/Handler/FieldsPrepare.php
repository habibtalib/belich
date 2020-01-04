<?php

namespace Daguilarm\Belich\Fields\Resolves\Handler;

use Closure;

final class FieldsPrepare
{
    /**
     * Prepare the fields for resolving...
     *
     * @param object $fields
     * @param object $sql
     *
     * @return Illuminate\Support\Collection
     */
    public function handle(object $fields, Closure $next): object
    {
        return $next($fields->flatten());
    }
}

