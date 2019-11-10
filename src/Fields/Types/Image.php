<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;
use Daguilarm\Belich\Fields\Types\File;

final class Image extends File
{
    /**
     * @var string
     */
    public $type = 'file';

    /**
     * @var string
     */
    public $alt;

    /**
     * @var string
     */
    public $fileType = 'image';

    /**
     * Set image alt value
     *
     * @param string $alt
     *
     * @return self
     */
    public function alt(string $alt): self
    {
        $this->alt = $alt;

        return $this;
    }
}
