<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

class Autocomplete extends Field {

    /** @var string */
    public $type = 'autocomplete';

    /** @var int */
    public $minChars = 2;

    /** @var array */
    public $addVars;

    /** @var string */
    public $responseArray;

    /** @var string */
    public $responseUrl;

    /** @var string */
    public $store = 'name';

    /**
     * Add variables to the url
     *
     * @param  array  $vars
     * @return self
     */
    public function addVars(...$vars) : self
    {
        $this->addVars = collect($vars)
            ->map(function($value) {
                return sprintf(
                    '%s=%s',
                    collect($value)->keys()->first(),
                    collect($value)->values()->first()
                );
            })
            ->filter()
            ->implode('&');

        return $this;
    }

    /**
     * Set the response from the data
     *
     * @param  string  $responseFrom
     * @return self
     */
    public function dataFrom(string $data) : self
    {
        if(is_array($data)) {
            $this->responseArray = $data;
        } elseif(is_string($data)) {
            $this->responseUrl = $data;
        }

        return $this;
    }

    /**
     * Set the min number of charts to start the ajax query
     *
     * @param  int  $number
     * @return self
     */
    public function minChars(int $minChars) : self
    {
        $this->minChars = $minChars;

        return $this;
    }

    /**
     * Set the response value
     *
     * @param  string  $value
     * @return self
     */
    public function store(string $value) : self
    {
        if(in_array($value, ['id', 'name'])) {
            $this->store = $value;
        }

        return $this;
    }
}
