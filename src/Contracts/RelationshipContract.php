<?php

namespace Daguilarm\Belich\Contracts;

use Daguilarm\Belich\Fields\Types\Relationship;

interface RelationshipContract
{
    /**
     * Get the Foreing key to connect the models
     *
     * @param string $key
     *
     * @return Daguilarm\Belich\Fields\Relationship
     */
    public function foreignKey(string $key): Relationship;
}
