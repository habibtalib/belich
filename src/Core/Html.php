<?php

namespace Daguilarm\Belich\Core;

use Illuminate\Support\Collection;

class Html {

    /** @var bool */
    protected static $allowedParameters = [
        'direction',
        'orderBy',
        'page'
    ];

    /**
     * Generate the link with all the parameters for the table header
     *
     * @param  Daguilarm\Belich\Fields\Field $field
     *
     * @return string
     */
    public static function orderedLink(object $field) : string
    {
        //Filter if the attribute is a relationship or is not sortable
        if(is_array($field->attribute) || $field->sortable === false) {
            return $field->label;
        }

        //Get url parameters
        $parameters = static::getUrlParameters($field);

        return sprintf('<a href="%s?%s">%s</a>', url()->current(), $parameters, $field->label);
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
    private static function allowedUrlParameters()
    {
        return config('belich.allowedUrlParameters')
            ? array_merge(static::$allowedParameters, config('belich.allowedUrlParameters'))
            : static::$allowedParameters;
    }

    /**
     * Get all the url parameters
     *
     * @param object $field
     * @return string
     */
    private static function getUrlParameters(object $field) : string
    {
        //Get the url parameters
        $parameters = collect(request()->query())
            //Only the allowed parameters
            ->filter(function($value, $key) {
                return in_array($key, static::allowedUrlParameters());
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
        $parameters = static::setUrlParametersDefaultValues($field, $parameters);

        //Serialize the parameters
        return static::setUrlParametersSerialized($parameters);
    }

    /**
     * Get all the url parameters
     *
     * @param object $field
     * @param Illuminate\Support\Collection $parameters
     * @return Illuminate\Support\Collection
     */
    private static function setUrlParametersDefaultValues(object $field, Collection $parameters) : Collection
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
    private static function setUrlParametersSerialized(Collection $parameters) : string
    {
        return $parameters
            ->map(function($value, $key) {
                return sprintf('%s=%s', $key, $value);
            })
            ->implode('&');
    }
}
