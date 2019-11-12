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
     * @var bool
     */
    public $fullText = false;

    /**
     * @var bool
     */
    public $fullTextOnIndex = false;

    /**
     * @var bool
     */
    public $fullTextOnShow = false;

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

        //Cast the field as string
        $this->toString();

        if($this->fullText === false) {
            $this->asHtml();
        }
    }

    /**
     * Show textArea full text in index and show views
     *
     * @return  self
     */
    public function fullText(): self
    {
        $this->fullText = true;

        return $this;
    }

    /**
     * Show textArea full text on index view
     *
     * @return  self
     */
    public function fullTextOnIndex(): self
    {
        $this->fullTextOnIndex = true;

        return $this;
    }

    /**
     * Show textArea full text on show view
     *
     * @return  self
     */
    public function fullTextOnShow(): self
    {
        $this->fullTextOnShow = true;

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
}
