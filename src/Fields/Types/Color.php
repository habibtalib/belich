<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

final class Color extends Field
{
    public string $type = 'color';
    public bool $asColor = false;

    /**
     * Resolve as color
     */
    public function asColor(): self
    {
        $this->asColor = true;

        return $this;
    }
}
