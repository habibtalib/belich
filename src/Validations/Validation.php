<?php

namespace Daguilarm\Belich\Validations;

use Daguilarm\Belich\Fields\FieldsConstructor as Fields;

class Validation {

    private $field;

    public function __construct()
    {
        $this->field = new Fields();
    }

    public function make()
    {
        $fields = $this->field->fieldListByAttribute();
        $stub = file_get_contents(__DIR__ . '/javascript.stub');
        $settings = $this->field->settings();

        dd($settings);
    }
}
