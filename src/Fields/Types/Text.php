<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

class Text extends Field {

    /** @var string */
    public $type = 'text';

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
        $this->disabled             = true;

        return $this;
    }
}
