<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Contracts\FieldMultipleContract;

final class Email extends Text implements FieldMultipleContract
{
    /**
     * @var string
     */
    public $type = 'email';

    /**
     * @var bool
     */
    public $multiple = false;

    /**
     * Allow multiple emails (coma separate)
     *
     * @return self
     */
    public function multiple(): self
    {
        $this->multiple = true;

        return $this;
    }
}
