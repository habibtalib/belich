<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

class Countries extends Field {

    /** @var string */
    public $type = 'countries';

    /** @var array */
    public $response;

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
        $this->response = collect(trans('belich::metrics.countriesOfTheWorldWithCodes'))
            ->flatMap(function($country) {
                return [$country['code'] => $country['name']];
            })
            ->all();

        //Resolve value for: index and show
        $this->resolveUsing(function($model) use ($attribute) {
            //Get the sql value
            $attribute = $model->{$attribute};
            //Set the label value
            return $this->response[$attribute];
        });
    }
}
