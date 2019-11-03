<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

class Text extends Field
{
    /** @var string */
    public $type = 'text';

    /**
     * Create a new field.
     *
     * @param  string|null  $name
     * @param  string|null  $attribute
     */
    public function __construct($name = null, $attribute = null)
    {
        parent::__construct($name, $attribute);

        //Cast the field as string
        $this->toString();
    }

    /**
     * Set relationship field
     *
     * @return self
     */
    public function withRelationship($relationship) : self
    {
        $this->fieldRelationship = $relationship;

        //Update attributes: hide from creating and disable from editing
        $this->visibility['create'] = false;
        $this->disabled = true;

        return $this;
    }
}
