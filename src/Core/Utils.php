<?php

namespace Daguilarm\Belich\Core;

use Daguilarm\Belich\Core\Helpers;
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

        return abort(404);
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

        return sprintf('%s/?%s', url()->current(), $this->serializeParameters($parameters));
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
     * @param  object $data
     * @param  mixed $attribute
     *
     * @return string
     */
    private function value(object $data, $attribute) : string
    {
        //Relationship
        if(is_array($attribute) && count($attribute) === 2) {
            return $data->{$attribute[0]}->{$attribute[1]} ?? emptyResults();
        }

        //Regular value
        return $data->{$attribute} ?? emptyResults();
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

    /**
     * Serialize all the url parameters
     *
     * @param array $parameters
     * @return string
     */
    private function serializeParameters($parameters = null)
    {
        return collect($parameters ?? $this->urlParameters())
            ->map(function($value, $key) {
                return sprintf('%s=%s', $key, $value);
            })
            ->values()
            ->implode('&');
    }

    /**
     * Get the base path for the package
     *
     * @return string
     */
    private function basePath() : string
    {
        return basePath();
    }

    /**
     * Generate the form route for the action attribute
     *
     * @param string $redirectTo ['index', 'edit', 'update', 'show']
     * @return string
     */
    private function formRedirectTo(string $redirectTo) : string
    {
        $route = sprintf('%s.%s.%s', $this->basePath(), Helpers::resource(), $redirectTo);
        $id    = Helpers::resourceId() ?? 0;

        return ($id > 0)
            ? route($route, $id)
            : route($route);
    }
}
