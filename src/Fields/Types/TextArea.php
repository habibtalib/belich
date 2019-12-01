<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

class TextArea extends Field
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
    public $markdown = false;

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
     * Render the textArea to markdown format
     *
     * @return  self
     */
    public function markdown(): self
    {
        $this->markdown = true;

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
     * Disabled method
     * Set the attribute default value
     *
     * @param  string|null  $value
     *
     * @return Daguilarm\Belich\Fields\Field
     */
    public function defaultValue($value = null): Field
    {
        //Check the value for conditional cases...
        if (isset($value)) {
            $this->value = $value;
        }

        return $this;
    }

    /**
     * Disabled method
     * Resolving field value in index and detailed
     *
     * @param  object  $displayCallback
     *
     * @return Daguilarm\Belich\Fields\Field
     */
    public function displayUsing(callable $displayCallback): Field
    {
        return $this;
    }

    /**
     * Disabled method
     * Prefix for field value
     *
     * @param  string  $prefix
     * @param  bool  $space
     *
     * @return Daguilarm\Belich\Fields\Field
     */
    public function prefix(string $prefix, bool $space = false): Field
    {
        return $this;
    }

    /**
     * Disabled method
     * Resolving field value (before processing) in all the fields
     *
     * @param  object  $resolveCallback
     *
     * @return Daguilarm\Belich\Fields\Field
     */
    public function resolveUsing(callable $resolveCallback): Field
    {
        return $this;
    }

    /**
     * Disabled method
     * Suffix for field value
     *
     * @param  string  $suffix
     * @param  bool  $space
     *
     * @return Daguilarm\Belich\Fields\Field
     */
    public function suffix(string $suffix, bool $space = false): Field
    {
        return $this;
    }
}
