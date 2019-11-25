<?php

namespace Daguilarm\Belich\Contracts;

use Daguilarm\Belich\Fields\Field;
use Daguilarm\Belich\Fields\Types\Relationship;

interface RelationshipContract
{
    /**
     * Get the URI key for the card
     *
     * @param array $attributes
     *
     * @return Daguilarm\Belich\Fields\Relationship
     */
    public static function make(...$attributes);

    /**
     * Get the Foreing key to connect the models
     *
     * @param string $key
     *
     * @return Daguilarm\Belich\Fields\Relationship
     */
    public function foreignKey(string $key);

    /**
     * Resolve value for index
     *
     * @param  object $data
     *
     * @return string
     */
    public function index(?object $data = null): string;

    /**
     * Resolve value for show
     *
     * @param  object $field
     * @param  object|null $data
     *
     * @return object
     */
    public function show(object $field, ?object $data = null): object;

    /**
     * Resolve value for create
     *
     * @param  object $data
     *
     * @return string|null
     */
    public function create(object $field, ?object $data = null): ?string;

    /**
     * Resolve value for edit
     *
     * @param  object $data
     *
     * @return string|null
     */
    public function edit(object $field, ?object $data = null): ?string;
}
