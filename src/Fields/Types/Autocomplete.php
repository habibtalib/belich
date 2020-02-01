<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;
use Daguilarm\Belich\Fields\Traits\Disabled\NoDisplayable;
use Daguilarm\Belich\Fields\Traits\Disabled\NoDuskable;
use Daguilarm\Belich\Fields\Traits\Disabled\NoPrefixable;

class Autocomplete extends Field
{
    use NoDisplayable,
        NoDuskable,
        NoPrefixable;

    public string $type = 'autocomplete';
    public int $minChars = 2;
    public string $addVars = '';
    public array $responseArray = [];
    public string $responseUrl = '';
    public string $store = '';

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
     *
     * @param string|array $data
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
}
