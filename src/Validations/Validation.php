<?php

namespace Daguilarm\Belich\Validations;

use Daguilarm\Belich\Fields\FieldsConstructor as Fields;

class Validation {

    /**
     * Fields values
     *
     * @var object
     */
    private $fields;

    /**
     * Fields settings
     *
     * @var array
     */
    private $settings;

    /**
     * Initialize the constructor
     *
     * @return void
     */
    public function __construct()
    {
        $newFields = (new Fields());
        $this->fields = $newFields->handle();
        $this->settings = $newFields->settings();
    }

    /**
     * Return the javascript
     *
     * @return void
     */
    public function make()
    {
        //Generate the values
        return collect([
            'javascript' => $this->setJavascript()
        ]);
    }

    /**
     * Parse the javascript
     *
     * @return void
     */
    private function setJavascript() {
        //Get the data from the fields
        $values = $this->setValues();

        //Generate the javascript form fields
        $formValues = $this->formValues($values);

        //Generate the validation rules
        $formValidationRules = $this->formValidationRules($values);

        //Generate the validation attributes
        $formValidationAttributes = $this->formValidationAttributes($values);

        //Get the javascript stub
        $stub = \File::get(config_path('belich/stubs/validate-form.stub'));

        return str_replace(
            [':resource', ':action', ':values', ':validationRules', ':validationAttributes'],
            [$this->settings['resource'], $this->settings['action'], $formValues, $formValidationRules, $formValidationAttributes],
            $stub
        );
    }

    /**
     * Set the values from the fields
     *
     * @return object
     */
    private function setValues() : object
    {
        return collect($this->fields)->mapWithKeys(function($field, $key) {
            return [
                $field->attribute => [
                    $field->name ?? null,
                    //Define the rules
                    $this->selectRules($this->settings['action'], $field)
                ]
            ];
        });
    }

    /**
     * Set javascript form values
     *
     * @param array $values
     * @return string
     */
    private function formValues($values) : string
    {
        return collect($values)
            ->map(function($value, $key) {
                return sprintf("%s:$('#%s').val()", $key, $key);
            })
            ->implode(',');
    }

    /**
     * Set form validation rules
     *
     * @param array $values
     * @return json
     */
    private function formValidationRules($values) : string
    {
        return collect($values)
            ->map(function($value) {
                return $value[1];
            })
            //Remove the empty rules
            ->filter(function($item) {
                return !empty($item);
            })
            ->toJson();
    }

    /**
     * Set form validation attributes
     *
     * @param array $values
     * @return json
     */
    private function formValidationAttributes($values) : string
    {
        return collect($values)
            ->map(function($value, $key) {
                return $value[0];
            })
            ->toJson();
    }

    /**
     * Set the validation rules for the field base on the current action
     *
     * @param string $action
     * @param array $field
     * @return mixed empty|array
     */
    private function selectRules($action, $field)
    {
        if($action === 'create' && !empty($field->creationRules)) {
            return $field->creationRules;
        }

        if($action === 'update' && !empty($field->updateRules)) {
            return $field->updateRules;
        }

        return $field->rules ?? '';
    }
}
