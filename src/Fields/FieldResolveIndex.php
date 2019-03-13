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
        $fields = $fields->map(function($field) {
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
