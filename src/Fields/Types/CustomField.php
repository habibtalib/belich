<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Contracts\FieldContract;
use Daguilarm\Belich\Fields\Field;

class CustomField extends Field implements FieldContract
{
    /**
     * @var string
     */
    public $type = 'custom';

    /**
     * @var string
     */
    public $className;

    /**
     * Init constructor
     * The method index() is resolved in Daguilarm\Belich\Fields\Resolves\Blade
     * The method show() is resolved in Daguilarm\Belich\Fields\Resolves\Value@actionShow
     */
    public function __construct(string $label, string $attribute, ?string $class)
    {
        parent::__construct($label, $attribute, $class);

        // Get the class name
        $this->className = $this->getClassName($class);

        // Custom view
        view()->addLocation(app_path() . '/Belich/Components/' . $this->className . '/resources/views');
    }

    /**
     * Set the field attributes
     *
     * @param  string|null  $attributes
     *
     * @return Daguilarm\Belich\Fields\Field
     */
    public static function make(...$attributes): Field
    {
        //Set the field values
        return new static(...$attributes);
    }

    /**
     * Get the class name
     *
     * @param  string|null  $class
     *
     * @return string
     */
    private function getClassName(string $class): string
    {
        // Class name
        $classItems = explode('\\', $class);

        return end($classItems);
    }
}
