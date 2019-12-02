<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Core\Belich;
use Daguilarm\Belich\Fields\Field;

final class ID extends Field
{
    /**
     * @var string
     */
    public $type = 'text';

    /**
     * Create a new field.
     *
     * @param  string|null  $name
     * @param  string|null  $attribute
     *
     * @return  void
     */
    public function __construct($name = null, $attribute = 'id')
    {
        parent::__construct($name ?? 'ID', $attribute ?? Belich::getModelKeyName());

        //Set visibility
        $this->forceVisibility('index', 'show');

        //Not resolve or display field
        $this->notResolveField();
    }
}
