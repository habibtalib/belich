<?php

namespace Daguilarm\Belich\Fields\Validates;

use Daguilarm\Belich\Fields\Validates\Form;
use Daguilarm\Belich\Fields\Validates\Javascript;
use Daguilarm\Belich\Fields\Validates\Values;
use Illuminate\Support\Collection;

final class Validate
{
    /**
     * @var string
     */
    private $controllerAction;

    /**
     * @var Daguilarm\Belich\Fields\Validate\Form
     */
    private $form;

    /**
     * @var Daguilarm\Belich\Fields\Validate\Javascript
     */
    private $javascript;

    /**
     * @var Daguilarm\Belich\Fields\Validates\Rules
     */
    private $rules;

    /**
     * @var Daguilarm\Belich\Fields\Validate\Values
     */
    private $values;

    /**
     * Init constructor
     */
    public function __construct(Form $form, Javascript $javascript, Rules $rules, Values $values)
    {
        $this->form = $form;
        $this->javascript = $javascript;
        $this->rules = $rules;
        $this->values = $values;
    }

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
        $fields = $this->values->get($resource, $this->rules, $this->controllerAction);

        //Generate the javascript code to get the current
        //value of each field and pass it to the validation
        $formValues = $this->form->values($fields);

        //Generate the validation rules
        //The rules are stored in a javascript variable (validationRules) and formated with json
        $formValidationRules = $this->form->rules($fields, $this->controllerAction);

        //Generate the validation attributes
        //The attributes are stored in a javascript variable (validationAttributes) and formated with json
        $formValidationAttributes = $this->form->attributes($fields);

        //Render the javascript
        return collect([
            'javascript' => $this->javascript->render(
                $formValidationAttributes,
                $this->controllerAction,
                $this->resource,
                $formValidationRules,
                $formValues,
            ),
        ]);
    }
}
