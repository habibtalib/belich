<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Types\File;

final class Image extends File
{
    public string $type = 'file';
    public string $alt;
    public string $fileType = 'image';

    /**
     * Set image alt value
     */
    public function alt(string $alt): self
    {
        $this->alt = $alt;

        return $this;
    }
}
