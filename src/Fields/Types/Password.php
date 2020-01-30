<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

class Password extends Field
{
    public string $type = 'password';

    public function __construct($name = null, $attribute = null)
    {
        parent::__construct($name, $attribute);

        // Only visible on forms and show
        $this->forceVisibility('create', 'edit');

        // Hash the value
        $this->toHash();
    }
}
