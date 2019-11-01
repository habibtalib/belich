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
    public $store;

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
     * @param  string|array  $responseFrom
     * @return self
     */
    public function dataFrom($data) : self
    {
        if(is_array($data)) {
            $this->responseArray = $data;
        }

        if(is_string($data)) {
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
     * @return self
     */
    public function storeId() : self
    {
        $this->store = 'id';

        return $this;
    }
}
