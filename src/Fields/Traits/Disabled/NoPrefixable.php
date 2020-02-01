<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Traits\Disabled;

use Daguilarm\Belich\Fields\Field;

trait NoPrefixable
{
    /**
     * Disabled method the method: prefix
     */
    public function prefix(?string $prefix, bool $space = false): Field
    {
        return $this;
    }

    /**
     * Disabled method the method: suffix
     */
    public function suffix(?string $suffix, bool $space = false): Field
    {
        return $this;
    }
}
