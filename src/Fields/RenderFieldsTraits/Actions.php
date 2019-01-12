<?php

namespace Daguilarm\Belich\Fields\RenderFieldsTraits;

trait Actions {

    /**
     * Generate the fields base on the current controller action
     *
     * @param object $fields
     * @return object
     */
    public function action($fields)
    {
        //Index action: Return only the name and the attribute for each field.
        if($this->action === 'index') {
            return $this->basePath('Fields\RenderFieldsTrait\Actions')
                ->actionIndex($fields);
        }

        //Edit action
        //Show action
        if($this->routeId > 0) {
            //Fill the field value with the model
            return $this->basePath('Fields\RenderFieldsTrait\Values')
                ->fillValue($fields);
        }

        return $fields;
    }

    /**
     * Generate the fields base on the index controller action
     *
     * @param object $fields
     * @return object
     */
    public function actionIndex($fields)
    {
        $fields = collect($fields)
            ->mapWithKeys(function($field, $key) {
                return [$field->name => $field->attribute];
            })->all();

        return collect([
            'attributes' => array_values($fields),
            'data' => $this->model,
            'labels' => array_keys($fields),
        ]);
    }
}
