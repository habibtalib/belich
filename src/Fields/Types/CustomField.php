<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Contracts\FieldContract;
use Daguilarm\Belich\Fields\Field;

class CustomField extends Field implements FieldContract
{
    public string $type = 'custom';
    public string $className;

    /**
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
     */
    public static function make(...$attributes): Field
    {
        //Set the field values
        return new static(...$attributes);
    }

    /**
     * Get the class name
     */
    private function getClassName(string $class): string
    {
        // Class name
        $classItems = explode('\\', $class);

        return end($classItems);
    }
}
