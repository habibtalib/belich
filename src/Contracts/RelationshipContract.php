<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Contracts;

use Daguilarm\Belich\Fields\Types\Relationship;

interface RelationshipContract
{
    /**
     * Get the Foreing key to connect the models
     */
    public function foreignKey(string $key): Relationship;
}
