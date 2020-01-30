<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Contracts;

interface CrudContract
{
    /**
     * Resolve value for index
     */
    public function index(object $field, ?object $data = null): ?string;

    /**
     * Resolve value for create
     */
    public function create(object $field, ?object $data = null): ?string;

    /**
     * Resolve value for edit
     */
    public function edit(object $field, ?object $data = null): ?string;

    /**
     * Resolve value for show
     */
    public function show(object $field, ?object $data = null): ?string;
}
