<?php

namespace Daguilarm\Belich\Fields\Types;

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
}
