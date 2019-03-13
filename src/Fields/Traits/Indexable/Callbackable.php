<?php

namespace Daguilarm\Belich\Fields\Traits\Indexable;

use Daguilarm\Belich\Fields\Field;

trait Callbackable {

    /**
     * Resolve field value through callbacks
     *
     * @param Daguilarm\Belich\Fields\Field $field
     * @param object $data
     * @param null|string $value
     * @return null|string
     */
    protected function getCallbackValue(Field $field, object $data = null, $value = '')
    {
        //Resolve value when using the method: $field->displayUsing()
        $value = $this->displayCallback($field, $value);

        //Resolve value when using the method: $field->resolveUsingg()
        return $this->resolveCallback($field, $data, $value);
    }

    /**
     * Resolve field callback: $field->displayUsing()
     *
     * @param Daguilarm\Belich\Fields\Field $field
     * @param null|string $value
     * @return null|string
     */
    private function displayCallback(Field $field, $value = '')
    {
        if(!empty($field->displayCallback)) {
            foreach($field->displayCallback as $callback) {
                if(is_callable($callback)) {
                    $value = call_user_func($callback, $value);
                }
            }
        }

        return $value;
    }

    /**
     * Resolve field callback: $field->resolveUsing()
     *
     * @param Daguilarm\Belich\Fields\Field $field
     * @param object $data
     * @param null|string $value
     * @return null|string
     */
    private function resolveCallback(Field $field, object $data = null, $value = '')
    {
        //Resolve value when using the method: $field->resolveUsing()
        if(is_callable($field->resolveCallback)) {
            //Add the data for the show view
            //No need to resolve for index because the $data variable is already available
            if(Belich::action() === 'show') {
                $data = $field->data;
            }

            $value = call_user_func($field->resolveCallback, $data);
        }

        return $value;
    }
}
