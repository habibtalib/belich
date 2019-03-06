<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

class File extends Field {

    /** @var string */
    public $type = 'file';

    /** @var string */
    public $disk;

    /** @var bool */
    public $prunable;

    /** @var bool */
    public $storeOriginalName;

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
