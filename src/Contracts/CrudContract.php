<?php

namespace Daguilarm\Belich\Contracts;

interface CrudContract
{
    /**
     * Resolve value for index
     *
     * @param  object $field
     * @param  object $data
     *
     * @return string|null
     */
    public function index(object $field, ?object $data = null): ?string;

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

    /**
     * Resolve value for show
     *
     * @param  object $field
     * @param  object|null $data
     */
    public function show(object $field, ?object $data = null);
}
