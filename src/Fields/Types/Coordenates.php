<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Traits\Disabled\NoPrefixable;
use Daguilarm\Belich\Fields\Traits\Disabled\NoResolvable;
use Daguilarm\Belich\Fields\Types\Decimal;

final class Coordenates extends Decimal
{
    use NoPrefixable,
        NoResolvable;

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
}
