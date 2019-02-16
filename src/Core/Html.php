<?php

namespace Daguilarm\Belich\Core;

use Daguilarm\Belich\Fields\Field;
use Daguilarm\Belich\Fields\FieldResolve;
use Illuminate\Support\Collection;

class Html {

    /** @var bool */
    protected $allowedParameters = [
        'direction',
        'orderBy',
        'page',
        'withTrashed'
    ];

    /**
     * Generate the link with all the parameters for the table header
     *
     * @param  Daguilarm\Belich\Fields\Field $field
     *
     * @return string
     */
    public function tableLink(Field $field) : string
    {
        //Filter if the attribute is a relationship or is not sortable
        if(is_array($field->attribute) || $field->sortable === false) {
            return $field->label;
        }

        //Get url parameters
        $parameters = $this->getUrlParameters($field);

        return sprintf('<a href="%s?%s">%s</a>', url()->current(), $parameters, $field->label);
    }

    /**
     * Resolve field
     *
     * @param  Daguilarm\Belich\Fields\Field $field
     * @param  object $data
     *
     * @return string
     */
    public function resolve(Field $field, object $data = null) : string
    {
        return FieldResolve::resolveField($field, $data);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Allowed url parameters
     *
     * @return array
     */
    private function allowedUrlParameters()
    {
        return config('belich.allowedUrlParameters')
            ? array_merge($this->allowedParameters, config('belich.allowedUrlParameters'))
            : $this->allowedParameters;
    }

    /**
     * Get all the url parameters
     *
     * @param Daguilarm\Belich\Fields\Field $field
     * @return string
     */
    private function getUrlParameters(Field $field) : string
    {
        //Get the url parameters
        $parameters = collect(request()->query())
            //Only the allowed parameters
            ->filter(function($value, $key) {
                return in_array($key, $this->allowedUrlParameters());
            })
            ->unique()
            ->map(function($value, $key) use ($field) {
                //Set orderBy
                if($key === 'orderBy') {
                    return $field->attribute;
                }

                //Set direction
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
     * @param Daguilarm\Belich\Fields\Field $field
     * @param Illuminate\Support\Collection $parameters
     * @return Illuminate\Support\Collection
     */
    private function setUrlParametersDefaultValues(Field $field, Collection $parameters) : Collection
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
