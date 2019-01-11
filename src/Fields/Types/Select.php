<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

class Select extends Field {

    /**
     * Field type
     *
     * @var string
     */
    public $type = 'select';

    /**
     * Field options
     *
     * @var array
     */
    public $options;

    /**
     * Add option values to the select
     *
     * @param array $options
     * @var void
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
