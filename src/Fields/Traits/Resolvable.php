<?php

namespace Daguilarm\Belich\Fields\Traits;

use Daguilarm\Belich\Facades\Belich;
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
     *
     * @var bool
     */
    public $notDisplayUsing;

    /**
     * Disable $this->resolveUsing()
     *
     * @var bool
     */
    public $notResolveUsing;

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
     *
     * @param  object  $displayCallback
     *
     * @return self
     */
    public function displayUsing(callable $displayCallback): self
    {
        $this->displayCallback[] = $displayCallback ?? [];

        return $this;
    }

    /**
     * Resolving field value (before processing) in all the fields
     *
     * @param  object  $resolveCallback
     *
     * @return self
     */
    public function resolveUsing(callable $resolveCallback): self
    {
        $this->resolveCallback = $resolveCallback;

        return $this;
    }

    /**
     * Resolve select field using labels
     * This method is helper for $this->resolve()
     *
     * @param  Daguilarm\Belich\Fields\Field $field
     * @param  string|null $value
     *
     * @return string|null
     */
    public function resolveTextArea(Field $field, ?string $value = null): ?string
    {
        // Default value
        $value = $value ?? $field->value;
        $shortValue = mb_strimwidth($value, 0, config('belich.textAreaChars'), '...');

        // Index and show resolve
        if ((Belich::action() === 'index' && $field->fullTextOnIndex) || (Belich::action() === 'show' && $field->fullTextOnShow)) {
            return $value;
        }

        return $field->fullText
            ? $value
            : $shortValue;
    }

    /**
     * Not Resolving field value
     * This is (mostly) for hidden fields
     *
     * @return self
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
