<?php

namespace Daguilarm\Belich\Fields;

use Daguilarm\Belich\Fields\Traits\Indexable\Linkeable;
use Illuminate\Support\Collection;

class FieldResolveIndex {

    use Linkeable;

    /**
     * Resolve fields: auth, visibility, value,...
     *
     * @param object $fields
     * @param object $sqlResponse
     * @return Illuminate\Support\Collection
     */
    public function make(object $fields, object $sqlResponse)
    {
        dd($this->headerLabels($fields));
    }
}
