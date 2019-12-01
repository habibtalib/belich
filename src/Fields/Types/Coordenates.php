<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;
use Daguilarm\Belich\Fields\Types\Decimal;

final class Coordenates extends Decimal
{
    /**
     * @var string
     */
    public $key;

    /**
     * @var string
     */
    public $coordenateType = 'latitude';

    /**
     * @var bool
     */
    public $toDegrees = false;

    /**
     * Create a new field.
     *
     * @param  string|null  $name
     * @param  string|null  $attribute
     *
     * @return  void
     */
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
     *
     * @return  self
     */
    public function toDegrees(string $type): self
    {
        $this->toDegrees = true;

        if ($type === 'lat' || $type === 'Lat' || $type === 'Latitude' || $type === 'latitude') {
            $this->coordenateType = 'latitude';
        } else {
            $this->coordenateType = 'longitude';
        }

        return $this;
    }

    /**
     * Disabled field
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
     * Disabled field
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
     * Disabled field
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
     * Disabled field
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
