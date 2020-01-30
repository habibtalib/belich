<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Contracts;

interface CustomFieldContract
{
    /**
     * Resolve value for index
     */
    public function index(object $field, ?object $data = null): ?object;

    /**
     * Resolve value for create
     */
    public function create(object $field, ?object $data = null): ?object;

    /**
     * Resolve value for edit
     */
    public function edit(object $field, ?object $data = null): ?object;

    /**
     * Resolve value for show
     *
     * @return  string|object|null
     */
    public function show(object $field, ?object $data = null): ?object;
}
