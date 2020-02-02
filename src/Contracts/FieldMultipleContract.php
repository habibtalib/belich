<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Contracts;

interface FieldMultipleContract
{
    /**
     * Add multiple attribute to fields: file or email
     */
    public function multiple(): self;
}
