<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;
use Daguilarm\Belich\Fields\Traits\Disabled\NoPrefixable;
use Daguilarm\Belich\Fields\Traits\Disabled\NoResolvable;

final class TextArea extends Field
{
    use NoPrefixable,
        NoResolvable;

    public string $type = 'textArea';
    public bool $count = false;
    public bool $fullText = false;
    public bool $fullTextOnIndex = false;
    public bool $fullTextOnShow = false;
    public int $rows;

    public function __construct($label, $attribute = null)
    {
        //Set the values
        parent::__construct($label, $attribute);

        //Cast the field as string
        $this->toString();
    }

    /**
     * Show textArea full text in index and show views
     */
    public function fullText(): self
    {
        $this->fullText = true;

        return $this;
    }

    /**
     * Show textArea full text on index view
     */
    public function fullTextOnIndex(): self
    {
        $this->fullTextOnIndex = true;

        return $this;
    }

    /**
     * Show textArea full text on show view
     */
    public function fullTextOnShow(): self
    {
        $this->fullTextOnShow = true;

        return $this;
    }

    /**
     * Show characters count
     */
    public function count(int $chars = 0): self
    {
        $this->count = true;
        $this->maxlength = $chars;

        return $this;
    }

    /**
     * Set the textArea rows
     */
    public function rows(int $rows): self
    {
        $this->rows = $rows;

        return $this;
    }

    /**
     * Disabled method
     * Set the attribute default value
     */
    public function defaultValue($value = null): Field
    {
        //Check the value for conditional cases...
        if (isset($value)) {
            $this->value = $value;
        }

        return $this;
    }
}
