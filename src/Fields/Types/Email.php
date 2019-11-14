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

        //Cast the field as string
        $this->toString();
    }

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
