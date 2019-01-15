<?php

namespace Daguilarm\Belich\Fields\Traits\Relationships;

trait hasRelationship {

    protected function fieldHasRelationship(string $attribute) : bool
    {
        $items = explode('.', $attribute);

        return count($items) > 1
            ? true
            : false;
    }
}
