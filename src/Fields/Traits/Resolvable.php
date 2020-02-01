<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Traits;

use Daguilarm\Belich\Facades\Belich;
use Daguilarm\Belich\Facades\Helper;
use Daguilarm\Belich\Fields\Field;

trait Resolvable
{
    /**
     * For manipulate data
     *
     * @var \Closure|null
     */
    public $displayCallback;

    /**
     * Disable $this->displayUsing()
     */
    public bool $notDisplayUsing = false;

    /**
     * Disable $this->resolveUsing()
     */
    public bool $notResolveUsing = false;

    /**
     * For manipulate data
     *
     * @var \Closure|null
     */
    public $resolveCallback;

    /**
     * @var \Closure|null
     */
    public $seeCallback;

    /**
     * Resolving field value in index and detailed
     */
    public function displayUsing(callable $displayCallback): self
    {
        $this->displayCallback[] = $displayCallback ?? [];

        return $this;
    }

    /**
     * Resolving field value (before processing) in all the fields
     */
    public function resolveUsing(callable $resolveCallback): self
    {
        $this->resolveCallback = $resolveCallback;

        return $this;
    }

    /**
     * Resolve select field using labels
     * This method is helper for $this->resolve()
     */
    protected function resolveTextArea(Field $field, ?string $value = null): ?string
    {
        // Default value
        $value = $value ?? $field->value;

        if ($field->type === 'markdown') {
            $value = Helper::markdown($value);
        }

        // Index and show resolve
        if ((Belich::action() === 'index' && $field->fullTextOnIndex) || (Belich::action() === 'show' && $field->fullTextOnShow)) {
            return $value;
        }
        return $field->fullText
            ? $value
            : Helper::stringMaxChars($value);
    }

    /**
     * Not Resolving field value
     * This is (mostly) for hidden fields
     */
    protected function notResolveField(): self
    {
        //Not display using
        $this->notDisplayUsing = false;

        //Not resolve using
        $this->notResolveUsing = false;

        return $this;
    }
}
