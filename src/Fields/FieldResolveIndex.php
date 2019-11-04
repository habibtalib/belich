<?php

namespace Daguilarm\Belich\Fields;

use Daguilarm\Belich\Fields\Traits\Constructable\Callbackable;
use Daguilarm\Belich\Fields\Traits\Constructable\Fileable;
use Daguilarm\Belich\Fields\Traits\Constructable\Linkeable;
use Daguilarm\Belich\Fields\Traits\Constructable\Resolvable;
use Daguilarm\Belich\Fields\Traits\Constructable\Softdeleteable;
use Illuminate\Support\Collection;

class FieldResolveIndex
{
    use Callbackable,
        Fileable,
        Linkeable,
        Resolvable,
        Softdeleteable;

    /**
     * Resolve fields: auth, visibility, value,...
     *
     * @param object $fields
     * @param object $sqlResponse
     *
     * @return Illuminate\Support\Collection
     */
    public function make(object $fields, object $sqlResponse): Collection
    {
        $fields = $fields->map(static function ($field) {
            //Showing field relationship in index
            //See blade template: dashboard.index
            $field->attribute = $field->fieldRelationship
                //Prepare field for relationship
                ? [$field->fieldRelationship, $field->attribute]
                //No relationship field
                : $field->attribute;

            return $field;
        });

        return collect([
            'data' => $fields,
            'labels' => $this->headerLabels($fields),
        ]);
    }
}
