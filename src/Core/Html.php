<?php

namespace Daguilarm\Belich\Core;

use Illuminate\Support\Collection;

abstract class Html {

    /** @var bool */
    protected $allowedParameters = [
        'direction',
        'orderBy',
        'page'
    ];

    /** @var bool */
    protected $toBlade = false;

    /**
     * Blade constructor
     *
     * @return this
     */
    public function blade()
    {
        $this->toBlade = true;

        return $this;
    }

    /**
     * Generate the link with all the parameters for the table header
     *
     * @param  Daguilarm\Belich\Fields\Field $field
     *
     * @return string
     */
    public function renderOrderedLink(object $field) : string
    {
        if(!$this->toBlade) {
            return null;
        }

        //Filter if the attribute is a relationship or is not sortable
        if(is_array($field->attribute) || $field->sortable === false) {
            return $field->label;
        }

        //Get url parameters
        $parameters = $this->getUrlParameters($field);

        return sprintf('<a href="%s?%s">%s</a>', url()->current(), $parameters, $field->label);
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
     * Generate the form route for the action attribute
     *
     * @param string $redirectTo ['index', 'edit', 'update', 'show']
     * @return string
     */
    public function toRoute(string $redirectTo) : string
    {
        $route = sprintf('%s.%s.%s', Helpers::pathName(), Helpers::resource(), $redirectTo);
        $id = Helpers::resourceId() ?? 0;

        return ($id > 0)
            ? route($route, $id)
            : route($route);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Get all the url parameters
     *
     * @param object $field
     * @return string
     */
    private function getUrlParameters(object $field) : string
    {
        //Get the url parameters
        $parameters = collect(request()->query())
            //Only the allowed parameters
            ->filter(function($value, $key) {
                return in_array($key, $this->allowedParameters);
            })
            ->unique()
            ->map(function($value, $key) use ($field) {
                if($key === 'direction') {
                    //Set only the allowed direction values
                    if($value !== 'DESC' && $value !== 'ASC') {
                        return 'DESC';
                    }
                    //Change order
                    return ($value === 'DESC') ? 'ASC' : 'DESC';
                }

                return $value;
            });

        //Set the default parameters values for the urls
        $parameters = $this->setUrlParametersDefaultValues($field, $parameters);

        //Serialize the parameters
        return $this->setUrlParametersSerialized($parameters);
    }

    /**
     * Get all the url parameters
     *
     * @param object $field
     * @param Illuminate\Support\Collection $parameters
     * @return Illuminate\Support\Collection
     */
    private function setUrlParametersDefaultValues(object $field, Collection $parameters) : Collection
    {
        if(!$parameters->get('orderBy')) {
            $parameters->put('orderBy', $field->attribute);
        }

        if(!$parameters->get('direction')) {
            $parameters->put('direction', 'DESC');
        }

        return $parameters;
    }

    /**
     * Serialize the url parameters
     *
     * @param Illuminate\Support\Collection $parameters
     * @return string
     */
    private function setUrlParametersSerialized(Collection $parameters) : string
    {
        return $parameters
            ->map(function($value, $key) {
                return sprintf('%s=%s', $key, $value);
            })
            ->implode('&');
    }
}
