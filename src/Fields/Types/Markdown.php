<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

final class Markdown extends Field
{
    /**
     * @var string
     */
    public $type = 'markdown';

    /**
     * @var bool
     */
    public $fullText;

    /**
     * @var bool
     */
    public $fullTextOnIndex;

    /**
     * @var bool
     */
    public $fullTextOnShow;

    /**
     * @var bool
     */
    public $preview;

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
        $this->asHtml = true;

        // Visibility
        $this->hideFromIndex();
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
     * Alias
     * Show textArea full text on show view
     *
     * @return  self
     */
    public function fullTextOnDetail(): self
    {
        $this->fullTextOnShow();

        return $this;
    }

    /**
     * Show a markdown preview
     *
     * @return  self
     */
    public function preview(): self
    {
        $this->preview = true;

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
