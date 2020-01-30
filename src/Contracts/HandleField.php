<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Contracts;

use Closure;

interface HandleField
{
    /**
     * Handle color field
     */
    public function handle(object $field, Closure $next): object;
}
