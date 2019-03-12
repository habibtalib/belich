<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

class File extends Field {

    /** @var string */
    public $type = 'file';

    /** @var string */
    public $fileType = 'file';

    /** @var string */
    public $disk = 'public';

    /** @var bool */
    public $storeOriginalName = 0;

    /**
     * Create a new field.
     *
     * @param  string|null  $name
     * @param  string|null  $attribute
     */
    public function __construct($name = null, $attribute = null)
    {
        parent::__construct($name, $attribute);

        //Set the html by default because we are showing icons as value (green or grey)
        $this->asHtml = true;

        //Default rules
        $this->rules('image', 'mimes:jpeg,png,jpg,gif,svg');
    }

    /**
     * Set storage disk
     *
     * @return self
     */
    public function disk(string $disk) : self
    {
        $this->disk = $disk;

        return $this;
    }

    /**
     * Set storage disk
     *
     * @return self
     */
    public function prunable() : self
    {
        $this->prunable = true;

        return $this;
    }

    /**
     * Set original storage name
     *
     * @return self
     */
    public function storeOriginalName() : self
    {
        $this->storeOriginalName = true;

        return $this;
    }
}
