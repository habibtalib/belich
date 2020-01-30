<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Contracts;

interface ComponentContract
{
    /**
     * Get the URI key for the card
     */
    public function uriKey(): string;
}
