<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Facades\Belich;
use Daguilarm\Belich\Fields\Field;

class Boolean extends Field {

    /**
     * Field type
     *
     * @var string
     */
    public $type = 'boolean';

    /**
     * Create a new field.
     *
     * @param  string|null  $name
     * @param  string|null  $attribute
     */
    public function __construct($name = null, $attribute = null)
    {
        parent::__construct($name, $attribute);
    }
}
