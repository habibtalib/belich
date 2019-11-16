<?php

namespace Daguilarm\Belich\Fields\Relationships;

class HasOne
{
    // /**
    //  * Create a new field
    //  *
    //  * @param  string  $model
    //  * @param  string|null  $relationshipKey
    //  *
    //  * @return  void
    //  */
    // public function __construct(string $model, ?string $relationshipKey = null)
    // {
    //     //nothing
    // }

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
}
