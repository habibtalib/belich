<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Contracts\FieldMultipleContract;
use Daguilarm\Belich\Fields\Types\Text;

final class Email extends Text implements FieldMultipleContract
{
    public bool $multiple = false;

    /**
     * Allow multiple emails (coma separate)
     */
    public function multiple(): self
    {
        $this->multiple = true;

        return $this;
    }
}
