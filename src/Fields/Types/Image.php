<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Facades\Belich;
use Daguilarm\Belich\Fields\Types\File;

class Image extends File {

    /** @var string */
    public $type = 'file';

    /** @var string */
    public $fileType = 'image';

    /**
     * Create a new field.
     *
     * @param  string|null  $name
     * @param  string|null  $attribute
     */
    public function __construct($name = null, $attribute = null)
    {
        parent::__construct($name, $attribute);

        //Default rules
        $this->rules('image');
    }
}
