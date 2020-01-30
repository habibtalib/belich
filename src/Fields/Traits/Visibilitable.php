<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Traits;

trait Visibilitable
{
    public array $forceVisibility = [
        'index',
        'create',
        'edit',
        'show'
    ];
    public array $visibility = [
        'index' => true,
        'create' => true,
        'edit' => true,
        'show' => true,
    ];

    /**
     * Hide field from index
     */
    public function hideFromIndex(?Closure $callback = null): self
    {
        // if (! is_null($callback) && is_callable($callback)) {
        //     $this->visibilityCallback[] = ['index', false, $callback];

        //     return $this;
        // }

        $this->visibility['index'] = false;

        return $this;
    }

    /**
     * Hide field when show a resource
     */
    public function hideFromShow(): self
    {
        $this->visibility['show'] = false;

        return $this;
    }

    /**
     * Hide field when show a resource (alias)
     */
    public function hideFromDetail(): self
    {
        $this->hideFromShow();

        return $this;
    }

    /**
     * Hide field when creating a resource
     */
    public function hideWhenCreating(): self
    {
        $this->visibility['create'] = false;

        return $this;
    }

    /**
     * Hide field when updating a resource
     */
    public function hideWhenEditing(): self
    {
        $this->visibility['edit'] = false;

        return $this;
    }

    /**
     * Hide field when updating a resource (alias)
     */
    public function hideWhenUpdating(): self
    {
        $this->hideWhenEditing();

        return $this;
    }

    /**
     * Hide field when creating or updating a resource
     */
    public function exceptOnForms(): self
    {
        self::hideFromAll();

        $this->visibility['index'] = true;
        $this->visibility['show'] = true;

        return $this;
    }

    /**
     * Show field only when creating or updating a resource
     */
    public function onlyOnForms(): self
    {
        self::hideFromAll();

        $this->visibility['create'] = true;
        $this->visibility['edit'] = true;

        return $this;
    }

    /**
     * Show field only on index
     */
    public function onlyOnIndex(): self
    {
        self::hideFromAll();

        $this->visibility['index'] = true;

        return $this;
    }

    /**
     * Show field only on show
     */
    public function onlyOnShow(): self
    {
        self::hideFromAll();

        $this->visibility['show'] = true;

        return $this;
    }

    /**
     * Show field only on show (alias)
     */
    public function onlyOnDetail(): self
    {
        $this->onlyOnShow();

        return $this;
    }

    /**
     * Show field only on editing
     */
    public function onlyOnEditing(): self
    {
        self::hideFromAll();

        $this->visibility['edit'] = true;

        return $this;
    }

    /**
     * Show field only on editing (alias)
     */
    public function onlyOnUpdating(): self
    {
        $this->onlyOnEditing();

        return $this;
    }

    /**
     * Show field only on creating
     */
    public function onlyOnCreating(): self
    {
        self::hideFromAll();

        $this->visibility['create'] = true;

        return $this;
    }

    /**
     * Show field on index
     */
    public function showOnIndex()
    {
        $this->visibility['index'] = true;

        return $this;
    }

    /**
     * Show field on detail / show
     */
    public function showOnShow()
    {
        $this->visibility['show'] = true;

        return $this;
    }

    /**
     * Show field on detail / show (alias)
     */
    public function showOnDetail()
    {
        $this->showOnShow();

        return $this;
    }

    /**
     * Show field on creating / create
     */
    public function showOnCreating()
    {
        $this->visibility['create'] = true;

        return $this;
    }

    /**
     * Show field on updating / edit
     */
    public function showOnEditing()
    {
        $this->visibility['edit'] = true;

        return $this;
    }

    /**
     * Show field on updating / edit (alias)
     */
    public function showOnUpdating()
    {
        $this->showOnEditing();

        return $this;
    }

    /**
     * Field will be visible only on...
     */
    public function visibleOn(...$attributes): self
    {
        self::hideFromAll();

        //Showing fields
        collect($attributes)
            ->each(function ($attribute): void {
                $this->visibility[$attribute] = in_array($attribute, $this->allowedControllerActions)
                    ? true
                    : false;
            });

        return $this;
    }

    /**
     * Hide field only from...
     */
    public function hideFrom(...$attributes): self
    {
        self::showInAll();

        //Hidding fields
        collect($attributes)
            ->each(function ($attribute): void {
                $this->visibility[$attribute] = in_array($attribute, $this->allowedControllerActions)
                    ? false
                    : true;
            });

        return $this;
    }

    /**
     * Hide field for all actions
     */
    protected function hideFromAll(): void
    {
        //Hidding all fields
        collect($this->visibility)
            ->each(function ($value, $key): void {
                $this->visibility[$key] = false;
            });
    }

    /**
     * Force visibility
     * This is to allow the field visibility, directly from field's constructor
     * All the visibility methods will be useless if activate this
     */
    protected function forceVisibility(...$values): self
    {
        $this->forceVisibility = $values;

        return $this;
    }

    /**
     * Show field for all actions
     */
    protected function showInAll(): void
    {
        //Showing all fields
        collect($this->visibility)
            ->each(function ($value, $key): void {
                $this->visibility[$key] = true;
            });
    }
}
