<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Types\Autocomplete;

final class Countries extends Autocomplete
{
    /**
     * Create a new field.
     *
     * @param  string|null  $name
     * @param  string|null  $attribute
     */
    public function __construct($name = null, $attribute = null)
    {
        parent::__construct($name, $attribute);

        //Get the countries
        $this->responseArray = collect(trans('belich::metrics.countriesOfTheWorldWithCodes'))
            ->flatMap(static function ($country) {
                return [$country['code'] => $country['name']];
            })
            ->all();

        //Resolve value for: index and show
        $this->resolveUsing(function ($model) use ($attribute) {
            //Get the sql value
            $attribute = $model->{$attribute};
            //Set the label value
            return $this->responseArray[$attribute] ?? null;
        });
    }
}
