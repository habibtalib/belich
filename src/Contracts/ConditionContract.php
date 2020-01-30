<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Contracts;

interface ConditionContract
{
    /**
     * Resolve condition
     */
    public function condition(): bool;
}
