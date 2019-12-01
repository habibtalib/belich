<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Facades\Helper;
use Daguilarm\Belich\Fields\Field;

class Markdown extends Field
{
    /**
     * @var string
     */
    public $type = 'markdown';

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
        // Set the values
        parent::__construct($label, $attribute);

        // Cast the field as string
        $this->toString();

        // As html
        $this->asHtml();

        // Resolve markdown
        $this->displayUsing(function($value) {
            return Helper::markdown($value);
        });
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
