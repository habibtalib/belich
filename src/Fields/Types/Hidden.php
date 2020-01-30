<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

final class Hidden extends Field
{
    public string $type = 'hidden';

    public function __construct($name = null, $attribute = null)
    {
        parent::__construct($name, $attribute);

        // Only visible on forms
        $this->onlyOnForms();

        //Not resolve or display field
        $this->notResolveField();
    }
}
