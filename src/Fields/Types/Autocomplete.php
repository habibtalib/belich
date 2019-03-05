<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

class Autocomplete extends Field {

    /** @var string */
    public $type = 'autocomplete';

    /** @var array */
    public $response;

    /**
     * Create a new field.
     *
     * @param  string|null  $name
     * @param  string|null  $attribute
     */
    public function __construct($name = null, $attribute = null, $data = [])
    {
        parent::__construct($name, $attribute);

        //Get the data base on the format
        $this->response = $this->parserData($data);

        //Resolve value for: index and show
        $this->resolveUsing(function($model) use ($attribute) {
            //Get the sql value
            $attribute = $model->{$attribute};
            //Set the label value
            return $this->response[$attribute];
        });
    }

    /**
     * Parser data.
     *
     * @param  mixed  $data
     * @return array
     */
    private function parserData($data) : array
    {
        //If is array
        if(array_keys($data)[0] === 'array') {
            return array_values($data)[0];
        }
    }
}
