<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Facades\Belich;
use Daguilarm\Belich\Fields\Field;

class Boolean extends Field {

    /** @var array */
    private $defaultColors = ['green', 'red', 'blue'];

    /** @var string */
    public $color = 'green';

    /**
     * Field type
     *
     * @var string
     */
    public $type = 'boolean';

    /**
     * Create a new field.
     *
     * @param  string|null  $name
     * @param  string|null  $attribute
     */
    public function __construct($name = null, $attribute = null)
    {
        parent::__construct($name, $attribute);
    }

    /**
     * Set the boolean color
     *
     * @param  string  $color
     * @return string
     */
    public function color(string $color)
    {
        $this->color = in_array($color, $this->defaultColors) ? $color : 'normal';

        return $this;
    }
}
