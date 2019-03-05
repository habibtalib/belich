<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Types\Autocomplete;

class Countries extends Autocomplete {

    /**
     * Create a new field.
     *
     * @param  string|null  $name
     * @param  string|null  $attribute
     */
    public function __construct($name = null, $attribute = null, $data = [])
    {
        $countries = collect(trans('belich::metrics.countriesOfTheWorldWithCodes'))
            ->flatMap(function($country) {
                return [$country['code'] => $country['name']];
            })
            ->all();

        parent::__construct($name, $attribute, ['array' => $countries]);
    }
}
