<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Traits;

trait Formatable
{
    private array $_textAlignAllowed = ['left', 'center', 'right', 'justify'];

    /**
     * Set a field internal text align
     */
    public function textAlign(string $value): self
    {
        //Check the value for conditional cases...
        if (in_array($value, $this->_textAlignAllowed)) {
            $this->addClass[] = 'text-' . $value;
        }

        return $this;
    }
}
