<?php

namespace Daguilarm\Belich\Fields;

use Daguilarm\Belich\Core\Traits\Systemable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use MatthiasMullie\Minify;

final class FieldValidate
{
    use Systemable;

    /**
     * @var string
     */
    private $controllerAction;

    /**
     * Stub replace values
     *
     * @var array
     */
    private $stubReplace = [
        ':resource',
        ':action',
        ':values',
        ':validationRules',
        ':validationAttributes',
        ':validationRuoute',
    ];

    /**
     * Return the javascript
     *
     * @param Illuminate\Support\Collection $resource
     *
     * @return Illuminate\Support\Collection
     */
    public function create(Collection $resource): Collection
    {
        //Set the resource name
        $this->resource = $resource['name'];

        //Set the controller action
        $this->controllerAction = $resource['controllerAction'];

        //Get the data from the fields
        $fields = $this->values($resource);

        //Generate the javascript code to get the current
        //value of each field and pass it to the validation
        $formValues = $this->formValues($fields);

        //Generate the validation rules
        //The rules are stored in a javascript variable (validationRules) and formated with json
        $formValidationRules = $this->formValidationRules($fields);

        //Generate the validation attributes
        //The attributes are stored in a javascript variable (validationAttributes) and formated with json
        $formValidationAttributes = $this->formValidationAttributes($fields);

        //Render the javascript
        return collect([
            'javascript' => $this->javascript($formValues, $formValidationRules, $formValidationAttributes),
        ]);
    }

    /**
     * Set the values from the fields.
     * This is only to store all the data in one place...
     *
     * @param Illuminate\Support\Collection $resource
     *
     * @return Illuminate\Support\Collection
     */
    private function values(Collection $resource): Collection
    {
        return $resource['fields']
            ->mapWithKeys(function ($field) {
                return [
                    $field->id => [
                        $field->label,
                        $field->id ?? null,
                        //Define the rules base on the action
                        $this->createRules($field),
                    ],
                ];
            })->filter(static function ($field): bool {
                // Removed empty fields with database relation, like: Header::make().
                return isset($field[0]) && $field[0] && isset($field[1]) && $field[1];
            });
    }

    /**
     * Set the validation rules for the field base on the current action
     *
     * @param object $field
     *
     * @return array
     */
    private function createRules(object $field): array
    {
        return array_merge($this->currentRules($field), $field->defaultRules ?? []);
    }

    /**
     * Get the current rules for each controller action
     * It is an helper for $this->createRules($field)
     *
     * @param object $field
     *
     * @return array
     */
    private function currentRules(object $field): array
    {
        $rules = [
            'create' => $field->creationRules ?? $field->rules ?? [],
            'edit' => $field->updateRules ?? $field->rules ?? [],
        ];

        return in_array($this->controllerAction, array_keys($rules))
            //Create or edit rules
            ? $rules[$this->controllerAction]
            // Default rules
            : $field->rules ?? [];
    }

    /**
     * Set javascript form values.
     * Just completing the javascript code with the vales from the form fields
     *
     * @param Illuminate\Support\Collection $values
     *
     * @return string
     */
    private function formValues(Collection $values): string
    {
        return collect($values)
            ->map(static function ($value, $attribute) {
                if (isset($value) && isset($attribute)) {
                    return sprintf("%s:document.getElementById('%s').value", $attribute, $attribute);
                }
            })
            ->filter()
            ->implode(',');
    }

    /**
     * Set form validation rules
     * Generate an array with the validation rules for each field
     *
     * @param Illuminate\Support\Collection $values
     *
     * @return string
     */
    private function formValidationRules(Collection $values): string
    {
        return collect($values)
            ->map(static function ($value) {
                //Get the current rule
                return collect($value)->last();
            })
            //Remove the empty rules
            ->filter();
    }

    /**
     * Set form validation attributes
     * This is helpful for project with localization
     *
     * @param Illuminate\Support\Collection $values
     *
     * @return string|json
     */
    private function formValidationAttributes(Collection $values): string
    {
        return collect($values)
            ->map(static function ($attribute) {
                return collect($attribute)->first();
            });
    }

    /**
     * Minify the javascript
     *
     * @param string $script
     *
     * @return string
     */
    private function javascriptMinify(string $script): string
    {
        //Minify the javascript code
        $minifier = new Minify\Js($script);

        return $minifier->minify();
    }

    /**
     * Render the javascript code
     *
     * @param string $values
     * @param string $rules
     * @param string $values
     *
     * @return string
     */
    private function javascript(string $values, string $rules, string $attributes): string
    {
        //Get the javascript stub
        $stub = File::get(config_path('belich/stubs/validate-form.stub'));

        //Set the route for validation
        $route = route(Systemable::pathName() .'.ajax.form.validation');

        //Stub values
        $stubValues = [
            $this->resource,
            $this->controllerAction,
            $values,
            $rules,
            $attributes,
            $route,
        ];

        //Get the javascript code
        $script = str_replace($this->stubReplace, $stubValues, $stub);

        //Minify the javascript code
        return $this->javascriptMinify($script);
    }
}
