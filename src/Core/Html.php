<?php

namespace Daguilarm\Belich\Core;

use Daguilarm\Belich\Facades\Belich;
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
     * Resolve field values for: relationship, displayUsing and resolveUsing
     * This method is used throw Belich Facade => Belich::html()->resolveField($field, $data);
     * This method is for refactoring the blade templates.
     *
     * @param  Daguilarm\Belich\Fields\Field $attribute
     * @param  object $data
     * @return string
     */
    public function resolve(Field $field, object $data = null) : string
    {
        //Resolve Relationship
        if(is_array($field->attribute) && count($field->attribute) === 2 && !empty($data)) {
            $value = $data->{$field->attribute[0]}->{$field->attribute[1]} ?? emptyResults();

        //Resolve value for action controller: edit
        } elseif(!empty($data)) {
            $value = $data->{$field->attribute} ?? emptyResults();

        //Resolve value for action controller: show
        } else {
            $value = $field->value;
        }

        //Resolve the field value through callbacks
        return $this->getCallbackValue($field, $data, $value);
    }

    /*
    |--------------------------------------------------------------------------
    | Callbacks
    |--------------------------------------------------------------------------
    */

    /**
     * Resolve field value through callbacks
     *
     * @param Daguilarm\Belich\Fields\Field $field
     * @param object $data
     * @param string $value
     * @return string
     */
    private function getCallbackValue(Field $field, object $data = null, string $value = '') : string
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
     * @param string $value
     * @return string
     */
    private function displayCallback(Field $field, string $value = '') : string
    {
        if(is_callable($field->displayCallback)) {
            $value = call_user_func($field->displayCallback, $value);
        }

        return $value;
    }

    /**
     * Resolve field callback: $field->resolveUsing()
     *
     * @param Daguilarm\Belich\Fields\Field $field
     * @param object $data
     * @param string $value
     * @return string
     */
    private function resolveCallback(Field $field, object $data = null, string $value = '') : string
    {
        //Resolve value when using the method: $field->resolveUsingg()
        if(is_callable($field->resolveCallback)) {
            //Add the data for the show view
            if(Belich::action() === 'show') {
                $data = $field->data;
            }

            $value = call_user_func($field->resolveCallback, $data);
        }

        return $value;
    }

    /*
    |--------------------------------------------------------------------------
    | Url parameters
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
                return $this->setOrderAndDirection($field, $key, $value);
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

    /**
     * Set value base on direction
     *
     * @param string $key
     * @param string $value
     * @return string
     */
    private function setValueFromDirection(string $key, string $value) : string
    {
        //Set only the allowed direction values
        if($value !== 'DESC' && $value !== 'ASC') {
            return 'DESC';
        }

        //Change order
        return ($value === 'DESC') ? 'ASC' : 'DESC';
    }

    /**
     * Set the values for order and direction
     *
     * @param Daguilarm\Belich\Fields\Field $field
     * @param string $key
     * @param string $value
     * @return string
     */
    private function setOrderAndDirection(Field $field, string $key, string $value) : string
    {
        //Set orderBy
        if($key === 'orderBy') {
            return $field->attribute;
        }

        //Set direction
        if($key === 'direction') {
            return $this->setValueFromDirection($key, $value);
        }

        return $value;
    }
}
