<?php

namespace Daguilarm\Belich\Fields;

use Daguilarm\Belich\Fields\ResolveFields as Fields;
use Daguilarm\Belich\Fields\Traits\Relationships\hasRelationship;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use MatthiasMullie\Minify;

class FieldValidate {

    use hasRelationship;

    /** @var string */
    private $controllerAction;

    /** @var array [Stub replace values] */
    private static $stubReplace = [
        ':resource',
        ':action',
        ':values',
        ':validationRules',
        ':validationAttributes',
        ':validationRuoute'
    ];

    /**
     * Return the javascript
     *
     * @return Illuminate\Support\Collection
     */
    public function create($resource) : Collection
    {
        //Set the controller action
        $this->controllerAction = $resource->get('controllerAction');

        //Set the resource name
        $this->resource = $resource->get('resource');

        //Get the data from the fields
        $fields = $this->setValues($resource);

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

    /*
    |--------------------------------------------------------------------------
    | Private methods
    |--------------------------------------------------------------------------
    */

    /**
     * Set the values from the fields.
     * This is only to store all the data in one place...
     *
     * @return Illuminate\Support\Collection
     */
    private function setValues($resource) : Collection
    {
        return $resource->get('fields')
            ->mapWithKeys(function($field, $key) {
                return [
                    $field->attribute => [
                        $field->attribute ?? null,
                        //Define the rules base on the action
                        $this->setRules($field)
                    ]
                ];
        })
        //Ignore validation for relationship on regular fields like: text, select,...
        ->filter(function($item) {
            return !$this->fieldHasRelationship($item[0]);
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
        if($this->controllerAction === 'create') {
            return $field->creationRules ?? $field->rules ?? '';
        }

        if($this->controllerAction === 'edit') {
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
     * @return string|json
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
     * @return string|json
     */
    private function formValidationAttributes($values) : string
    {
        return collect($values)
            ->map(function($attribute) {
                return collect($attribute)->first();
            });
    }

    /**
     * Minify the javascript
     *
     * @param string $script
     * @return string
     */
    private function javascriptMinify($script) : string
    {
        //Minify the javascript code
        $minifier = new Minify\Js($script);

        return $minifier->minify();
    }

    /**
     * Render the javascript code
     *
     * @param array $values
     * @return string
     */
    private function javascript($values, $rules, $attributes) : string
    {
        //Get the javascript stub
        $stub = File::get(config_path('belich/stubs/validate-form.stub'));

        //Set the route for validation
        $route = route(getRouteBasePath() .'.ajax.form.validation');

        //Stub values
        $stubValues = [
            $this->resource,
            $this->controllerAction,
            $values,
            $rules,
            $attributes, $route
        ];

        //Get the javascript code
        $script = str_replace(static::$stubReplace, $stubValues, $stub);

        //Minify the javascript code
        return self::javascriptMinify($script);
    }
}