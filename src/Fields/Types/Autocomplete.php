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
    public function __construct($name = null, $attribute = null, $data)
    {
        parent::__construct($name, $attribute);

        $this->response = $this->parserData($data);

        $this->resolveUsing(function($model) use ($attribute) {
            $attribute = $model->{$attribute};
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
        if(is_array($data)) {
            return $data['array'];
        }
    }
}
