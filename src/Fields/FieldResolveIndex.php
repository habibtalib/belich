<?php

namespace Daguilarm\Belich\Fields;

use Daguilarm\Belich\Fields\Traits\Indexable\Booleanable;
use Daguilarm\Belich\Fields\Traits\Indexable\Callabackable;
use Daguilarm\Belich\Fields\Traits\Indexable\Fileable;
use Daguilarm\Belich\Fields\Traits\Indexable\Linkeable;
use Daguilarm\Belich\Fields\Traits\Indexable\Resolvable;
use Daguilarm\Belich\Fields\Traits\Indexable\Softdeleteable;

class FieldResolveIndex {

    use Booleanable, Callabackable, Fileable, Linkeable, Resolvable, Softdeleteable;

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
