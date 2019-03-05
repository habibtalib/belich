<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

class Autocomplete extends Field {

    /** @var string */
    public $type = 'autocomplete';

    /** @var string */
    public $ajaxFrom;

    /** @var int */
    public $take;

    /** @var string */
    public $varName = 'search';

    /**
     * Set the ajax Url for the response
     *
     * @param  string  $responseFrom
     * @return self
     */
    private function ajaxFrom(string $ajaxFrom) : self
    {
        $this->ajaxFrom = $ajaxFrom;

        return $this;
    }

    /**
     * Set the max number of result for the response
     *
     * @param  int  $number
     * @return self
     */
    private function take(int $number) : self
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
    private function varName(string $varName) : self
    {
        $this->varName = $varName;

        return $this;
    }
}
