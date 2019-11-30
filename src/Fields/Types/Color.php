<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

final class Color extends Field
{
    /**
     * @var string
     */
    public $type = 'color';

    /**
     * @var string
     */
    public $asColor = false;

    /**
     * Resolve as color
     *
     * @return self
     */
    public function asColor(): self
    {
        $this->asColor = true;

        return $this;
    }
}
