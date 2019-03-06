<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

class Autocomplete extends Field {

    /** @var string */
    public $type = 'autocomplete';

    /** @var string */
    public $response;

    /** @var int */
    public $take;

    /** @var string */
    public $varName = 'search';

    /**
     * Set the response from the data
     *
     * @param  string  $responseFrom
     * @return self
     */
    public function response(string $response) : self
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Set the max number of result for the response
     *
     * @param  int  $number
     * @return self
     */
    public function take(int $number) : self
    {
        $this->varName = $name;

        return $this;
    }

    /**
     * Set the variable name
     *
     * @param  string  $url
     * @return self
     */
    public function varName(string $varName) : self
    {
        $this->varName = $varName;

        return $this;
    }
}
