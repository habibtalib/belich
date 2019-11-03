<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Facades\Belich;
use Daguilarm\Belich\Fields\Types\File;

class Image extends File
{
    /** @var string */
    public $type = 'file';

    /** @var string */
    public $fileType = 'image';

    /** @var string */
    public $alt;

    /** @var string */
    public $addCss;

    /**
     * Create a new field.
     *
     * @param  string|null  $name
     * @param  string|null  $attribute
     */
    public function __construct($name = null, $attribute = null)
    {
        parent::__construct($name, $attribute);
    }

    /**
     * Set image alt value
     *
     * @param string $alt
     * @return self
     */
    public function alt(string $alt)  : self
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Set the image css classes
     *
     * @param string $addCss
     * @return self
     */
    public function addCss(string $addCss)  : self
    {
        $this->addCss = $addCss;

        return $this;
    }
}
