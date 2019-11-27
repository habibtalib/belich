<?php

namespace Daguilarm\Belich\Contracts;

use Illuminate\Support\Collection;

interface CrudContract
{
    /**
     * Resolve value for index
     *
     * @param  object $field
     * @param  object $data
     *
     * @return string
     */
    public function index(object $field, ?object $data = null);

    /**
     * Resolve value for create
     *
     * @param  object $data
     *
     * @return string|null
     */
    public function create(object $field, ?object $data = null);

    /**
     * Resolve value for edit
     *
     * @param  object $data
     *
     * @return string|null
     */
    public function edit(object $field, ?object $data = null);

    /**
     * Resolve value for show
     *
     * @param  object $field
     * @param  object|null $data
     *
     * @return object
     */
    public function show(object $field, ?object $data = null);
}
