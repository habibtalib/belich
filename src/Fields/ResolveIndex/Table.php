<?php

namespace Daguilarm\Belich\Fields\ResolveIndex;

use Daguilarm\Belich\Fields\Field;
use Illuminate\Support\Collection;

final class Table
{
    /** @var bool */
    private $allowedParameters = [
        'direction',
        'orderBy',
        'page',
    ];

    /**
     * Get the table header labels
     *
     * @param Illuminate\Support\Collection $fields
     *
     * @return Illuminate\Support\Collection
     */
    public function headerLabels($fields): Collection
    {
        return $fields->map(function ($field) {
            return $this->headerLinks($field);
        });
    }

    /**
     * Generate the link with all the parameters for the table header
     *
     * @param  Daguilarm\Belich\Fields\Field $field
     *
     * @return string
     */
    private function headerLinks(Field $field): string
    {
        //Filter if the attribute is a relationship or is not sortable
        if (is_array($field->attribute) || $field->sortable === false) {
            return $field->label;
        }

        //Get url parameters
        $parameters = $this->getUrlParameters($field);

        return sprintf('<a href="%s?%s">%s</a>', url()->current(), $parameters, $field->label);
    }

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
     *
     * @return string
     */
    private function getUrlParameters(Field $field): string
    {
        //Get the url parameters
        $parameters = collect(request()->query())
            //Only the allowed parameters
            ->filter(function ($value, $key) {
                return in_array($key, $this->allowedUrlParameters());
            })
            ->unique()
            ->map(function ($value, $key) use ($field) {
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
     *
     * @return Illuminate\Support\Collection
     */
    private function setUrlParametersDefaultValues(Field $field, Collection $parameters): Collection
    {
        if (! $parameters->get('orderBy')) {
            $parameters->put('orderBy', $field->attribute);
        }

        if (! $parameters->get('direction')) {
            $parameters->put('direction', 'DESC');
        }

        return $parameters;
    }

    /**
     * Serialize the url parameters
     *
     * @param Illuminate\Support\Collection $parameters
     *
     * @return string
     */
    private function setUrlParametersSerialized(Collection $parameters): string
    {
        return $parameters
            ->map(static function ($value, $key) {
                return sprintf('%s=%s', $key, $value);
            })
            ->implode('&');
    }

    /**
     * Set the values for order and direction
     *
     * @param Daguilarm\Belich\Fields\Field $field
     * @param string $key
     * @param string $value
     *
     * @return string
     */
    private function setOrderAndDirection(Field $field, string $key, string $value): string
    {
        //Set orderBy
        if ($key === 'orderBy') {
            return $field->attribute;
        }

        //Set direction
        if ($key === 'direction') {
            return $this->setValueFromDirection($key, $value);
        }

        return $value;
    }

    /**
     * Set value base on direction
     *
     * @param string $key
     * @param string $value
     *
     * @return string
     */
    private function setValueFromDirection(string $key, string $value): string
    {
        //Change order
        return $value === 'DESC'
            ? 'ASC'
            : 'DESC';
    }
}
