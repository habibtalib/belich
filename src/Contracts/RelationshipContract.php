<?php

namespace Daguilarm\Belich\Contracts;

use Daguilarm\Belich\Fields\Relationship;

interface RelationshipContract
{
    /**
     * Get the URI key for the card
     *
     * @param array $attributes
     *
     * @return Daguilarm\Belich\Fields\Relationship
     */
    public static function make(...$attributes): Relationship;

    /**
     * Get the Foreing key to connect the models
     *
     * @param string $key
     *
     * @return Daguilarm\Belich\Fields\Relationship
     */
    public function foreignKey(string $key): Relationship;

    /**
     * Get the table row
     *
     * @param string $table
     *
     * @return Daguilarm\Belich\Fields\Relationship
     */
    public function table(string $table): Relationship;
}
