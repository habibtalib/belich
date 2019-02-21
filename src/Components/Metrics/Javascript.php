<?php

namespace Daguilarm\Belich\Components\Metrics;

use Illuminate\Support\Collection;

trait Javascript {

    /** @var array */
    public $labels;

    /** @var array */
    public $serie;

    /** @var string */
    public $type;

    /** @var string */
    public $uriKey;

    /**
     * Set the labels
     *
     * @param  array  $labels
     * @return self
     */
    public function labels(array $labels = []) : self
    {
        $this->labels = $this->serialize($labels);

        return $this;
    }

    /**
     * Set the serie
     *
     * @param  array  $serie
     * @return self
     */
    public function serie(array $serie = []) : self
    {
        $this->serie = $this->serialize($serie);

        return $this;
    }

    /**
     * Set the type
     *
     * @param  string  $type
     * @return self
     */
    public function type(string $type) : self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set the uriKey
     *
     * @param  string  $uriKey
     * @return self
     */
    public function uriKey(string $uriKey) : self
    {
        $this->uriKey = $uriKey;

        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Generate a serialized array
     *
     * @param  array|string|model  $array
     * @return string
     */
    private function serialize($values) : string
    {
        //Array to collection
        if(is_array($values)) {
            $values = collect($values);
        }

        //Convert to string
        if($values instanceof Collection) {
            $values = $values
                ->map(function($item) {
                    return sprintf("'%s'", $item);
                })
                ->filter()
                ->implode(',');
        }

        return sprintf('[%s]', $values);
    }
}
