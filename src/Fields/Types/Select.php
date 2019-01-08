<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

class Select extends Field {

    public $type = 'select';

    /**
     * Field options
     *
     * @var string
     */
    public $options = [];

    public function options(array $options = [])
    {
        //Check the text for conditional cases...
        if(!is_null($options)) {
            $this->options = $options;
        }

        return $this;
    }
}
