<?php

namespace Daguilarm\Belich\Validations;

use Daguilarm\Belich\Fields\RenderFields;
use Illuminate\Support\Facades\File;
use MatthiasMullie\Minify;

class Validation {

    /**
     * Resource action
     *
     * @var array
     */
    private $action;

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
     * Stub replace values
     *
     * @var array
     */
    private static $stubReplace = [
        ':resource',
        ':action',
        ':values',
        ':validationRules',
        ':validationAttributes',
        ':validationRuoute'
    ];

    /**
     * Initialize the constructor
     *
     * @return void
     */
    public function __construct()
    {
        $renderFields = new RenderFields();

        $this->fields = $renderFields->handle();
        $this->settings = collect($renderFields->settings());
        $this->action = $this->settings->get('action');
    }

    /**
     * Return the javascript
     *
     * @return void
     */
    public function make()
    {
        //Get the data from the fields
        $fields = $this->setValues();

        //Generate the javascript code to get the current
        //value of each field and pass it to the validation
        $formValues = $this->setFormValues($fields);

        //Generate the validation rules
        //The rules are stored in a javascript variable (validationRules) and formated with json
        $formValidationRules = $this->formValidationRules($fields);

        //Generate the validation attributes
        //The attributes are stored in a javascript variable (validationAttributes) and formated with json
        $formValidationAttributes = $this->formValidationAttributes($fields);

        //Render the javascript
        return collect([
            'javascript' => $this->javascript($formValues, $formValidationRules, $formValidationAttributes)
        ]);
    }

    /**
     * Set the values from the fields.
     * This is only to store all the data in one place...
     *
     * @return object
     */
    private function setValues() : object
    {
        return collect($this->fields)
            ->mapWithKeys(function($field, $key) {
                return [
                    $field->attribute => [
                        $field->name ?? null,
                        //Define the rules base on the action
                        $this->setRules($field)
                    ]
                ];
        });
    }

    /**
     * Set the validation rules for the field base on the current action
     *
     * @param string $action
     * @return mixed empty|array
     */
    private function setRules($field)
    {
        if($this->action === 'create') {
            return $field->creationRules ?? $field->rules ?? '';
        }

        if($this->action === 'edit') {
            return $field->updateRules ?? $field->rules ?? '';
        }

        return $field->rules ?? '';
    }

    /**
     * Set javascript form values.
     * Just completing the javascript code with the vales from the form fields
     *
     * @param array $values
     * @return string
     */
    private function setFormValues($values) : string
    {
        return collect($values)
            ->map(function($value, $attribute) {
                return sprintf("%s:$('#%s').val()", $attribute, $attribute);
            })
            ->implode(',');
    }

    /**
     * Set form validation rules
     * Generate an array with the validation rules for each field
     *
     * @param array $values
     * @return json
     */
    private function formValidationRules($values) : string
    {
        return collect($values)
            ->map(function($value) {
                //Get the current rule
                return collect($value)->last();
            })
            //Remove the empty rules
            ->filter(function($notEmpty) {
                return $notEmpty;
            });
    }

    /**
     * Set form validation attributes
     * This is helpful for project with localization
     *
     * @param array $values
     * @return json
     */
    private function formValidationAttributes($values) : string
    {
        return collect($values)
            ->map(function($attribute) {
                return collect($attribute)->first();
            });
    }

    /**
     * Render the javascript code
     *
     * @param array $values
     * @return json
     */
    private function javascript($values, $rules, $attributes) : string
    {
        //Get the javascript stub
        $stub = File::get(config_path('belich/stubs/validate-form.stub'));

        //Set the route for validation
        $route = route(getRouteBasePath() .'.ajax.form.validation');

        //Stub values
        $stubValues = [
            $this->settings->get('resource'),
            $this->settings->get('action'),
            $values,
            $rules,
            $attributes, $route
        ];

        //Get the javascript code
        $javascript = str_replace(static::$stubReplace, $stubValues, $stub);

        //Minify the javascript code
        $minifier = new Minify\Js($javascript);

        return $minifier->minify();
    }
}
