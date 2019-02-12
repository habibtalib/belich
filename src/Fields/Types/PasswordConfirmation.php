<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

class PasswordConfirmation extends Field {

    /**
     * Field type
     *
     * @var string
     */
    public $type = 'password';

    /**
     * Create a new field
     *
     * @param  string  $name
     * @param  string|null  $attribute
     * @return void
     */
    public function __construct($label, $attribute = null)
    {
        //Set the default value
        $title = 'password_confirmation';

        //Set the values
        $this->label             = $label;
        $this->attribute         = $title;
        $this->dusk              = 'dusk-' . $title;
        $this->id                = $title;
        $this->name              = $title;

        //Set visibility
        $this->onlyOnForms();
        $this->rules('required');
    }
}
