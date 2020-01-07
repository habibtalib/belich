<?php

namespace Daguilarm\Belich\Contracts;

interface ConditionContract
{
    /**
     * Resolve condition
     *
     * @return bool
     */
    public function condition(): bool;
}
