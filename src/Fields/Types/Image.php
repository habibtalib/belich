<?php

namespace Daguilarm\Belich\Fields\Types;

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
    public $fileType = 'image';

    /**
     * @var string
     */
    public $alt;

    /**
     * @var string
     */
    public $addCss;

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

    /**
     * Set the image css classes
     *
     * @param string $addCss
     *
     * @return self
     */
    public function addCss(string $addCss): self
    {
        $this->addCss = $addCss;

        return $this;
    }
}
