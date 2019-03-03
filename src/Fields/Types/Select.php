<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

class Select extends Field {

    /**  @var string */
    public $type = 'select';

    /** @var array */
    public $options;

    /**
     * Add option values to the select
     *
     * @param array $options
     */
    public function options(array $options = [])
    {
        //Check the text for conditional cases...
        if(!empty($options)) {
            $this->options = ['' => ''] + $options;
        }

        return $this;
    }
}
