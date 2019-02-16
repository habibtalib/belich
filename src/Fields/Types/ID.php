<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Facades\Belich;
use Daguilarm\Belich\Fields\Field;

class ID extends Field {

    /**
     * Field type
     *
     * @var string
     */
    public $type = 'text';

    /**
     * Create a new field.
     *
     * @param  string|null  $name
     * @param  string|null  $attribute
     * @return void
     */
    public function __construct($name = null, $attribute = null)
    {
        parent::__construct($name ?? 'ID', $attribute ?? Belich::getModelKeyName());

        //Set visibility
        $this->readonly();
    }
}
