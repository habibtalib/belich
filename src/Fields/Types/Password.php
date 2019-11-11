<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

final class Password extends Field
{
    /**
     * @var string
     */
    public $type = 'password';

    /**
     * Create a new field.
     *
     * @param  string|null  $name
     * @param  string|null  $attribute
     *
     * @return  void
     */
    public function __construct($name = null, $attribute = null)
    {
        parent::__construct($name, $attribute);

        // Only visible on forms and show
        $this->forceVisibility('create', 'edit');

        // Hash the value
        $this->toHash();
    }
}
