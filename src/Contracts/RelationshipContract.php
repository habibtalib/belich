<?php

namespace Daguilarm\Belich\Contracts;

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
     * @param  object $data
     *
     * @return string
     */
    public function show(?object $data = null): string;

    /**
     * Resolve value for create
     *
     * @param  object $data
     *
     * @return string
     */
    public function create(object $field, ?object $data = null): string;

    /**
     * Resolve value for edit
     *
     * @param  object $data
     *
     * @return string
     */
    public function edit(object $field, ?object $data = null): string;
}
