<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Contracts;

interface FieldNumberContract
{
    /**
     * Set min value
     */
    public function min(string $min): self;

    /**
     * Set max value
     */
    public function max(string $max): self;

    /**
     * Set step value
     */
    public function step(string $step): self;
}
