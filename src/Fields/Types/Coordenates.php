<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;
use Daguilarm\Belich\Fields\Types\Decimal;

final class Coordenates extends Decimal
{
    public string $key;
    public string $coordenateType = 'latitude';
    public bool $toDegrees = false;

    public function __construct($name = null, $attribute = null)
    {
        parent::__construct($name, $attribute);

        //Set decimals
        $this->decimals(6);

        //Not resolve or display field
        $this->notResolveField();
    }

    /**
     * Convert Latlng to degrees
     */
    public function toDegrees(string $type): self
    {
        $this->toDegrees = true;
        $this->coordenateType = 'longitude';

        if (in_array(strtolower($type), ['la', 'lat', 'lati', 'latit', 'latitu', 'latitud', 'latitude'])) {
            $this->coordenateType = 'latitude';
        }

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
     * Prefix for field value
     */
    public function prefix(string $prefix, bool $space = false): Field
    {
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

    /**
     * Disabled method
     * Suffix for field value
     */
    public function suffix(string $suffix, bool $space = false): Field
    {
        return $this;
    }
}
