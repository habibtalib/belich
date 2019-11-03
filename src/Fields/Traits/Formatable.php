<?php

namespace Daguilarm\Belich\Fields\Traits;

trait Formatable
{
    private $textAlignAllowed = ['left', 'center', 'right', 'justify'];

    /**
     * Set a field internal text align
     *
     * @param  string  $value
     * @return self
     */
    public function textAlign(string $value) : self
    {
        //Check the value for conditional cases...
        if(in_array($value, $this->textAlignAllowed)) {
            $this->addClass[] = 'text-' . $value;
        }

        return $this;
    }
}
