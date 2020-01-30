<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

class Autocomplete extends Field
{
    public string $type = 'autocomplete';
    public int $minChars = 2;
    public array $addVars = [];
    public array $responseArray = [];
    public string $responseUrl = '';
    public string $store;

    /**
     * Add variables to the url
     */
    public function addVars(...$vars): self
    {
        $this->addVars = collect($vars)
            ->map(static function ($value) {
                return sprintf(
                    '%s=%s',
                    collect($value)->keys()->first(),
                    collect($value)->values()->first()
                );
            })
            ->filter()
            ->implode('&');

        return $this;
    }

    /**
     * Set the response from the data
     */
    public function dataFrom($data): self
    {
        if (is_array($data)) {
            $this->responseArray = $data;
        }

        if (is_string($data)) {
            $this->responseUrl = $data;
        }

        return $this;
    }

    /**
     * Set the min number of charts to start the ajax query
     */
    public function minChars(int $minChars): self
    {
        $this->minChars = ! isset($minChars) ? $this->minChars : $minChars;

        return $this;
    }

    /**
     * Set the response value
     */
    public function storeId(): self
    {
        $this->store = 'id';

        return $this;
    }

    /**
     * Disabled method
     * Resolving field value in index and detailed
     */
    public function displayUsing(callable $displayCallback): Field
    {
        return $this;
    }

    /**
     * Disabled method
     * Set the attribute dusk
     */
    public function dusk($value = null): Field
    {
        return $this;
    }

    /**
     * Disabled method
     * Prefix for field value
     */
    public function prefix(string $prefix, bool $space = false): Field
    {
        return $this;
    }

    /**
     * Disabled method
     * Suffix for field value
     */
    public function suffix(string $suffix, bool $space = false): Field
    {
        return $this;
    }
}
