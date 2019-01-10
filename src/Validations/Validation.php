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
        //Default values
        $stub = \File::get(config_path('belich/stubs/validate-form.stub'));
        $fields = $this->field->fieldListByAttribute();
        $settings = $this->field->settings();

        //Generate fields for JS
        $values = collect($fields)->map(function($field) {
            return sprintf("%s: $('#%s').val()", $field, $field);
        })->implode(',');

        //Generate the JS
        return str_replace([':resource', ':action', ':values'], [$settings['resource'], $settings['action'], $values], $stub);
    }
}
