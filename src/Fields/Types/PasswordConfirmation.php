<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Types\Password;

final class PasswordConfirmation extends Password
{
    public function __construct($label)
    {
        // Set the default value
        $title = 'password_confirmation';

        // Set the values
        $this->label = $label;
        $this->attribute = $title;
        $this->dusk = 'dusk-' . $title;
        $this->id = $title;
        $this->name = $title;

        // Only visible on forms and show
        $this->forceVisibility('create', 'edit');
    }
}
