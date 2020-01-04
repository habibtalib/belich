<?php

namespace Daguilarm\Belich\Contracts;

use Closure;

interface HandleField
{
    /**
     * Handle color field
     *
     * @param object $field
     * @param Closure $next
     *
     * @return object
     */
    public function handle(object $field, Closure $next): object;
}
