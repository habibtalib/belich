<?php

namespace Daguilarm\Belich\Core;

abstract class Html {

    protected $toBlade = false;

    public function blade()
    {
        $this->toBlade = true;

        return $this;
    }

    /**
     * Resolve field values for: relationship, displayUsing and resolveUsing
     * Shorthand for blade
     *
     * @param  Daguilarm\Belich\Fields\Field $attribute
     * @param  object $data
     * @return string
     */
    public function resolveField(object $field, object $data = null) : string
    {
        if(!$this->toBlade) {
            return null;
        }

        return \Daguilarm\Belich\Fields\FieldResolve::resolveField($field, $data);
    }

    /**
     * Generate the url with all the parameters
     *
     * @param  array $urlParameters
     *
     * @return string
     */
    public function getUrl($urlParameters = null) : string
    {
        if(!$this->toBlade) {
            return null;
        }

        $parameters = $urlParameters ?? $this->getUrlWithOrder();

        return sprintf('%s/?%s', url()->current(), $this->getSerializedParameters($parameters));
    }

    /**
     * Generate the link with all the parameters for the table header
     *
     * @param  Daguilarm\Belich\Fields\Field $field
     *
     * @return string
     */
    public function getUrlWithOrder(object $field) : string
    {
        if(!$this->toBlade) {
            return null;
        }

        //Filter if the attribute is a relationship or is not sortable
        if(is_array($field->attribute) || $field->sortable === false) {
            return $field->label;
        }

        $parameters = array_merge($this->getUrlParameters(), [
            'order'     => $field->attribute,
            'direction' => $this->getUrlParameters('direction') === 'DESC' ? 'ASC' : 'DESC',
        ]);

        return sprintf('<a href="%s">%s</a>', $this->getUrl($parameters), $field->label);
    }


    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Get all the url parameters in an array or a selected one
     *
     * @param string $key
     * @return array|string
     */
    private function getUrlParameters($key = null)
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
    private function getSerializedParameters($parameters = null)
    {
        return collect($parameters ?? $this->getUrlParameters())
            ->map(function($value, $key) {
                return sprintf('%s=%s', $key, $value);
            })
            ->values()
            ->implode('&');
    }

    /**
     * Generate the form route for the action attribute
     *
     * @param string $redirectTo ['index', 'edit', 'update', 'show']
     * @return string
     */
    private function setformRedirectTo(string $redirectTo) : string
    {
        $route = sprintf('%s.%s.%s', Helpers::pathName(), Helpers::resource(), $redirectTo);
        $id = Helpers::resourceId() ?? 0;

        return ($id > 0)
            ? route($route, $id)
            : route($route);
    }
}
