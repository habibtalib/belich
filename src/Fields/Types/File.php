<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Contracts\FieldMultipleContract;
use Daguilarm\Belich\Fields\Field;

class File extends Field implements FieldMultipleContract
{
    public string $type = 'file';
    public bool $multiple = false;
    public string $disk = 'public';
    public bool $link = false;
    public string $fileType = 'file';
    public bool $renderImage = false;
    public string $storeMime;
    public string $storeName;
    public string $storeSize;
    // public bool $prunable = false;

    public function __construct($name = null, $attribute = null)
    {
        parent::__construct($name, $attribute);

        //Set the html by default because we are showing icons as value (green or grey)
        $this->asHtml = true;

        //Not resolve or display field
        $this->notResolveField();
    }

    /**
     * Set storage disk
     */
    public function disk(string $disk): self
    {
        $this->disk = $disk;

        return $this;
    }

    /**
     * Show a download link in views
     */
    public function link(): self
    {
        $this->link = true;

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
     */
    public function asHtml(): Field
    {
        $this->renderImage = true;

        return $this;
    }

    /**
     * Allow multiple files
     */
    public function multiple(): self
    {
        $this->multiple = true;

        return $this;
    }

    /**
     * Store the file original name as metadata
     * The name of the table row must be provided
     */
    public function storeName(string $tableName): self
    {
        $this->storeName = $tableName;

        return $this;
    }

    /**
     * Store the file size as metadata
     * The name of the table row must be provided
     */
    public function storeSize(string $tableName): self
    {
        $this->storeSize = $tableName;

        return $this;
    }

    /**
     * Store the file type MIME (text/css, image/gif, image/x-icon,...) as metadata
     * The name of the table row must be provided
     */
    public function storeMime(string $tableName): self
    {
        $this->storeMime = $tableName;

        return $this;
    }
}
