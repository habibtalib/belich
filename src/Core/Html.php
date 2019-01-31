<?php

namespace Daguilarm\Belich\Core;

use Daguilarm\Belich\Fields\Field;

class Html {

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
    private function urlBuilder($urlParameters = null) : string
    {
        $parameters = $urlParameters ?? request()->query();

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
    private function tableHeadLink(Field $field) : string
    {
        //Filter if attribute is a relationship or is not sortable
        if(is_array($field->attribute) || $field->sortable === false) {
            return $field->label;
        }

        //Get url parameters
        $urlParameters = request()->query();

        //Get order
        if(isset($urlParameters['direction']) && $urlParameters['direction'] === 'DESC') {
            $urlParameters = array_merge($urlParameters, [
                'order'     => $field->attribute,
                'direction' => 'ASC'
            ]);
        } else {
            $urlParameters = array_merge($urlParameters, [
                'order'     => $field->attribute,
                'direction' => 'DESC'
            ]);
        }

        return sprintf('<a href="%s">%s</a>', $this->urlBuilder($urlParameters), $field->label);
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
    function value(object $item, $attribute) : string
    {
        //Relationship
        if(is_array($attribute) && count($attribute) === 2) {
            return $item->{$attribute[0]}->{$attribute[1]} ?? emptyResults();
        }

        //Regular value
        return $item->{$attribute} ?? emptyResults();
    }
}
