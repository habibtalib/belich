<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

class File extends Field
{
    /**
     * @var string
     */
    public $type = 'file';

    /**
     * @var string
     */
    public $disk = 'public';

    /**
     * @var string
     */
    public $downloadable = false;

    /**
     * @var string
     */
    public $fileType = 'file';

    /**
     * @var  bool
     */
    // public $prunable = false;

    /**
     * @var bool
     */
    public $render = false;

    /**
     * @var string
     */
    public $storeName;

    /**
     * @var string
     */
    public $storeSize;

    /**
     * Create a new field.
     *
     * @param  string|null  $name
     * @param  string|null  $attribute
     *
     * @return  void
     */
    public function __construct($name = null, $attribute = null)
    {
        parent::__construct($name, $attribute);

        //Set the html by default because we are showing icons as value (green or grey)
        $this->asHtml = true;

        //Set the default rules for the field
        $this->defaultRules = ['file'];
    }

    /**
     * Set storage disk
     *
     * @return self
     */
    public function disk(string $disk): self
    {
        $this->disk = $disk;

        return $this;
    }

    /**
     * Show a download link in views
     *
     * @return self
     */
    public function downloadable(): self
    {
        $this->downloadable = true;

        return $this;
    }

    // /**
    //  * Delete file when delete related model
    //  *
    //  * @return self
    //  */
    // public function prunable(): self
    // {
    //     $this->prunable = true;

    //     return $this;
    // }

    /**
     * Render image in views
     *
     * @return self
     */
    public function render(): self
    {
        $this->render = true;

        return $this;
    }

    /**
     * Store the file original name as metadata
     * The name of the table row must be provided
     *
     * @param string $tableName
     *
     * @return self
     */
    public function storeName(string $tableName): self
    {
        $this->storeName = $tableName;

        return $this;
    }

    /**
     * Store the file size as metadata
     * The name of the table row must be provided
     *
     * @param string $tableName
     *
     * @return self
     */
    public function storeSize(string $tableName): self
    {
        $this->storeSize = $tableName;

        return $this;
    }

    /**
     * Store the file type MIME (text/css, image/gif, image/x-icon,...) as metadata
     * The name of the table row must be provided
     *
     * @return self
     */
    public function storeType(string $tableName): self
    {
        $this->storeSize = $tableName;

        return $this;
    }
}
