<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Facades\Helper;
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
     */
    public function __construct($name = null, $attribute = null)
    {
        parent::__construct($name, $attribute);

        //Set decimals
        $this->decimals(6);

        //Set key
        $this->key = md5($this->id . '-to-degrees');
    }

    /**
     * Latlng to degrees
     *
     * @return  self
     */
    public function latitude(): self
    {
        $this->coordenateType = 'latitude';

        return $this;
    }

    /**
     * Set to lng
     *
     * @return  self
     */
    public function longitude(): self
    {
        $this->coordenateType = 'latitude';

        return $this;
    }
}
