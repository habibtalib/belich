<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;
use Daguilarm\Belich\Fields\Traits\Disabled\NoPrefixable;

final class Markdown extends Field
{
    use NoPrefixable;

    public string  $type = 'markdown';
    public bool $fullText = false;
    public bool $fullTextOnIndex = false;
    public bool $fullTextOnShow = false;
    public bool $preview = false;

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
     * Alias
     * Show textArea full text on show view
     */
    public function fullTextOnDetail(): self
    {
        $this->fullTextOnShow();

        return $this;
    }

    /**
     * Show a markdown preview
     */
    public function preview(): self
    {
        $this->preview = true;

        return $this;
    }

    /**
     * Disabled method
     * Resolving field value (before processing) in all the fields
     */
    public function resolveUsing(callable $resolveCallback): Field
    {
        return $this;
    }
}
