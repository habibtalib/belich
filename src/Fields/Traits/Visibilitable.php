<?php

namespace Daguilarm\Belich\Fields\Traits;

trait Visibilitable
{
    /**
     * Force visibility
     * This is to allow the field visibility, directly from field's constructor
     * All the visibility methods will be useless if activate this
     *
     * @var array
     */
    public $forceVisibility = ['index', 'create', 'edit', 'show'];

    /**
     * Field visibility base on the action
     *
     * @var array
     */
    public $visibility = [
        'index' => true,
        'create' => true,
        'edit' => true,
        'show' => true,
    ];

    /**
     * Hide field from index
     *
     * @var self
     */
    public function hideFromIndex(): self
    {
        $this->visibility['index'] = false;

        return $this;
    }

    /**
     * Hide field when show a resource
     *
     * @var self
     */
    public function hideFromShow(): self
    {
        $this->visibility['show'] = false;

        return $this;
    }

    /**
     * Hide field when creating a resource
     *
     * @var self
     */
    public function hideWhenCreating(): self
    {
        $this->visibility['create'] = false;

        return $this;
    }

    /**
     * Hide field when updating a resource
     *
     * @var self
     */
    public function hideWhenEditing(): self
    {
        $this->visibility['edit'] = false;

        return $this;
    }

    /**
     * Hide field when creating or updating a resource
     *
     * @var self
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
     *
     * @var self
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
     *
     * @var self
     */
    public function onlyOnIndex(): self
    {
        self::hideFromAll();

        $this->visibility['index'] = true;

        return $this;
    }

    /**
     * Show field only on show
     *
     * @var self
     */
    public function onlyOnShow(): self
    {
        self::hideFromAll();

        $this->visibility['show'] = true;

        return $this;
    }

    /**
     * Show field only on editing
     *
     * @var self
     */
    public function onlyOnEditing(): self
    {
        self::hideFromAll();

        $this->visibility['edit'] = true;

        return $this;
    }

    /**
     * Show field only on creating
     *
     * @var self
     */
    public function onlyOnCreating(): self
    {
        self::hideFromAll();

        $this->visibility['create'] = true;

        return $this;
    }

    /**
     * Field will be visible only on...
     *
     * @var self
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
     *
     * @var self
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
     *
     * @var void
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
     *
     * @param array $values
     *
     * @return self
     */
    protected function forceVisibility(...$values): self
    {
        $this->forceVisibility = $values;

        return $this;
    }

    /**
     * Show field for all actions
     *
     * @var void
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
