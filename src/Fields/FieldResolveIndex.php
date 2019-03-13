<?php

namespace Daguilarm\Belich\Fields;

use Daguilarm\Belich\Fields\Traits\Indexable\{Booleanable, Callbackable, Fileable, Linkeable, Resolvable, Softdeleteable};

class FieldResolveIndex {

    use Booleanable,
        Callbackable,
        Fileable,
        Linkeable,
        Resolvable,
        Softdeleteable;

    /**
     * Resolve fields: auth, visibility, value,...
     *
     * @param object $fields
     * @param object $sqlResponse
     * @return Illuminate\Support\Collection
     */
    public function make(object $fields, object $sqlResponse)
    {
        $labels = $this->headerLabels($fields);
        dd($labels);
    }
}
