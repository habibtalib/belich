<?php

namespace Daguilarm\Belich\Core;

use Daguilarm\Belich\Fields\Field;

class Utils {

    /**
     * Generate the methods
     *
     * @param  string $method
     * @param  array $parameters
     *
     * @return Boolean
     */
    public function __call($method, $parameters)
    {
        if(method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $parameters);
        }
    }

    /**
     * Generate the url with all the parameters
     *
     * @param  array $urlParameters
     *
     * @return string
     */
    private function url($urlParameters = null) : string
    {
        $parameters = $urlParameters ?? $this->urlParameters();

        $query = collect($parameters)
            ->map(function($value, $key) {
                return sprintf('%s=%s', $key, $value);
            })
            ->values()
            ->implode('&');

        return sprintf('%s/?%s', url()->current(), $query);
    }

    /**
     * Generate the link with all the parameters for the table header
     *
     * @param  Daguilarm\Belich\Fields\Field $field
     *
     * @return string
     */
    private function urlWithOrder(Field $field) : string
    {
        //Filter if attribute is a relationship or is not sortable
        if(is_array($field->attribute) || $field->sortable === false) {
            return $field->label;
        }

        $parameters = array_merge($this->urlParameters(), [
            'order'     => $field->attribute,
            'direction' => $this->urlParameters('direction') === 'DESC' ? 'ASC' : 'DESC',
        ]);

        return sprintf('<a href="%s">%s</a>', $this->url($parameters), $field->label);
    }

    /**
     * Count the total results
     *
     * @param  array|object $value
     *
     * @return integer
     */
    private function count($value) : int
    {
        if(is_array($value)) {
            return count($value);
        }

        if(is_object($value)) {
            return $value->count();
        }

        return 0;
    }

    /**
     * Get value from object and attribute
     *
     * @param  object $item
     * @param  mixed $attribute
     *
     * @return string
     */
    private function value(object $item, $attribute) : string
    {
        //Relationship
        if(is_array($attribute) && count($attribute) === 2) {
            return $item->{$attribute[0]}->{$attribute[1]} ?? emptyResults();
        }

        //Regular value
        return $item->{$attribute} ?? emptyResults();
    }

    /**
     * Get all the url parameters in an array or a selected one
     *
     * @param string $key
     * @return array|string
     */
    private function urlParameters($key = null)
    {
        return $key
            ? request()->query($key)
            : request()->query();
    }
}
