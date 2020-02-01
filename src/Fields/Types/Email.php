<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Contracts\FieldMultipleContract;
use Daguilarm\Belich\Fields\Traits\Multiplable;
use Daguilarm\Belich\Fields\Types\Text;

final class Email extends Text implements FieldMultipleContract
{
    use Multiplable;

    public bool $multiple = false;
}
