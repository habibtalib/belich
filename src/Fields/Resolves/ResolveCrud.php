<?php

namespace Daguilarm\Belich\Fields\Resolves;

use Daguilarm\Belich\Fields\Resolves\Render;
use Daguilarm\Belich\Fields\Resolves\Value;
use Daguilarm\Belich\Fields\Resolves\Visible;
use Illuminate\Support\Collection;

final class ResolveCrud
{
    /**
     * Get controller action
     */
    public function __construct(string $action, Render $render, Value $value, Visible $visible)
    {
        $this->action = $action;
        $this->render = $render;
        $this->value = $value;
        $this->visible = $visible;
    }

    /**
     * Get the values base on the controllers action (except for index)
     *
     * @param Illuminate\Support\Collection $fields
     *
     * @return Illuminate\Support\Collection
     */
    public function controller(object $fields, object $sql): object
    {
        // Resolve visibility for fields
        $fields = $this->visible->execute($this->action, $fields);

        //Set fields attributes: Only for create and edit actions
        if ($this->action === 'create' || $this->action === 'edit') {
            // Creating all the render attributes for the forms
            $fields = $this->attributes($fields);
        }

        //Resolve values for fields: Only for Edit or Show actions
        if ($this->action === 'edit' || $this->action === 'show') {
            //Fill the field value with the model
            return $this->value->execute($fields, $sql);
        }

        return $fields;
    }

    /**
     * Generate the attributes for the fields
     *
     * @param Illuminate\Support\Collection $fields
     *
     * @return \Illuminate\Support\Collection
     */
    private function attributes(Collection $fields): Collection
    {
        // Set attributes for each field
        return $fields->map(function ($field) {
            // Add attributes dynamically from the list: name, id, dusk,...
            $field->render = $this->render->execute($field);

            //Add readonly attribute
            if ($field->readonly && $field->type !== 'hidden') {
                $field->render->push('readonly');
            }

            //Render field
            return $this->render($field);
        })
            // Spaces removed
            ->filter(static function ($field) {
                $field->render = trim($field->render);

                return $field;
            });
    }

    /**
     * Render each field value
     *
     * @param array $field
     *
     * @return object
     */
    private function render($field): object
    {
        $field->render = $field->render->implode(' ');

        return $field;
    }
}
