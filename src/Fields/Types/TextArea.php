<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

class TextArea extends Field {

    /**
     * Field type
     *
     * @var string
     */
    public $type = 'textArea';

    /** @var int */
    public $rows;

    /** @var int */
    public $maxlength;

    /**
     * Create a new field
     *
     * @param  string  $name
     * @param  string|null  $attribute
     */
    public function __construct($label, $attribute = null)
    {
        //Set the values
        $this->label     = $label;
        $this->attribute = $attribute;

        //Set visibility
        //Hide from detail by default
        $this->hideFromShow();
    }

    /**
     * Show textArea in all the actions
     *
     * @return  self
     */
    public function alwaysShow() : self
    {
        $this->showInAll();

        return $this;
    }

    /**
     * Show textArea in all the actions
     * Alias for alwaysShow()
     *
     * @return  self
     */
    public function show() : self
    {
        $this->showInAll();

        return $this;
    }

    /**
     * Set the textArea rows
     *
     * @return  self
     */
    public function rows(int $rows) : self
    {
        $this->rows = $rows;

        return $this;
    }

    /**
     * Set the textArea maximum length
     *
     * @return  self
     */
    public function maxlength(int $maxlength) : self
    {
        $this->maxlength = $maxlength;

        return $this;
    }
}
