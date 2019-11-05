<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

final class Coordenates extends Field
{
    /**
     * @var int|float
     */
    public $step = '.000001';

    /**
     * @var string
     */
    public $type = 'coordenates';
}
