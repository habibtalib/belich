<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

class Text extends Field
{
    public string $type = 'text';

    public function __construct($name = null, $attribute = null)
    {
        parent::__construct($name, $attribute);

        //Cast the field as string
        $this->toString();
    }

    /**
     * Set relationship field
     */
    public function withRelationship($relationship): self
    {
        $this->fieldRelationship = $relationship;

        //Update attributes: hide from creating and disable from editing
        $this->visibility['create'] = false;
        $this->disabled = true;

        return $this;
    }
}
