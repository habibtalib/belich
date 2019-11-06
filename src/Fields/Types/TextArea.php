<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

final class TextArea extends Field
{
    /**
     * @var string
     */
    public $type = 'textArea';

    /**
     * @var bool
     */
    public $count;

    /**
     * @var int
     */
    public $maxlength;

    /**
     * @var int
     */
    public $rows;

    /**
     * Create a new field
     *
     * @param  string  $name
     * @param  string|null  $attribute
     *
     * @return  void
     */
    public function __construct($label, $attribute = null)
    {
        //Set the values
        parent::__construct($label, $attribute);

        //Set visibility
        //Hide from detail by default
        $this->hideFromShow();

        //Cast the field as string
        $this->toString();
    }

    /**
     * Show textArea in all the actions
     *
     * @return  self
     */
    public function alwaysShow(): self
    {
        $this->showInAll();

        return $this;
    }

    /**
     * Show characters count
     *
     * @return  self
     */
    public function count(int $chars = 0): self
    {
        $this->count = true;
        $this->maxlength = $chars;

        return $this;
    }

    /**
     * Set the textArea maximum length
     *
     * @return  self
     */
    public function maxlength(int $maxlength): self
    {
        $this->maxlength = $maxlength;

        return $this;
    }

    /**
     * Set the textArea rows
     *
     * @return  self
     */
    public function rows(int $rows): self
    {
        $this->rows = $rows;

        return $this;
    }

    /**
     * Show textArea in show action
     * Alias for alwaysShow()
     *
     * @return  self
     */
    public function show(): self
    {
        $this->visibility['show'] = true;

        return $this;
    }
}
