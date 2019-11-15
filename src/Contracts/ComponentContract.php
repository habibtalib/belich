<?php

namespace Daguilarm\Belich\Contracts;

interface ComponentContract
{
    /**
     * Get the URI key for the card
     *
     * @return string
     */
    public function uriKey(): string;
}
