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
     * @var string
     */
    public $options = [];

    // /**
    //  * Display value as label
    //  *
    //  * @var string
    //  */
    // public $displayUsingLabels = false;

    public function options(array $options = [])
    {
        //Check the text for conditional cases...
        if(!empty($options)) {
            $this->options = $options;
        }

        return $this;
    }

    // public function displayUsingLabels()
    // {
    //     $this->displayUsingLabels = true;
    // }
}
