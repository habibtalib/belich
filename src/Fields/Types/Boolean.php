<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Facades\Belich;
use Daguilarm\Belich\Fields\Field;

class Boolean extends Field {

    /** @var array */
    private $defaultColors = ['green', 'red', 'blue'];

    /** @var string */
    public $color = 'green';

    /** @var string */
    public $falseValue;

    /** @var string */
    public $trueValue;

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
     * @return self
     */
    public function color(string $color) : self
    {
        $this->color = in_array($color, $this->defaultColors) ? $color : 'normal';

        return $this;
    }

    /**
     * Set the label for false
     *
     * @param  string  $value
     * @return self
     */
    public function falseValue(string $value) : self
    {
        $this->falseValue = $value;

        return $this;
    }

    /**
     * Set the label for true
     *
     * @param  string  $value
     * @return self
     */
    public function trueValue(string $value) : self
    {
        $this->trueValue = $value;

        return $this;
    }
}
