<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

class Hidden extends Field {

    /**
     * Field type
     *
     * @var string
     */
    public $type = 'hidden';

    /**
     * Create a new field.
     *
     * @param  string|null  $name
     * @param  string|null  $attribute
     */
    public function __construct($name = null, $attribute = null)
    {
        parent::__construct($name, $attribute);

        //Set configuration
        $this->onlyOnForms()->notResolveField();
    }
}
