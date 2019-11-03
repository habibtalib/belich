<?php

namespace Daguilarm\Belich\Fields\Traits;

trait Visibilitable
{
    /** @var array [Field visibility base on the action] */
    public $visibility = [
        'index' => true,
        'create' => true,
        'edit' => true,
        'show' => true
    ];

    /**
     * Hide field from index
     *
     * @var self
     */
    public function hideFromIndex() : self
    {
        $this->visibility['index'] = false;

        return $this;
    }

    /**
     * Hide field when show a resource
     *
     * @var self
     */
    public function hideFromShow() : self
    {
        $this->visibility['show'] = false;

        return $this;
    }

    /**
     * Hide field when creating a resource
     *
     * @var self
     */
    public function hideWhenCreating() : self
    {
        $this->visibility['create'] = false;

        return $this;
    }

    /**
     * Hide field when updating a resource
     *
     * @var self
     */
    public function hideWhenEditing() : self
    {
        $this->visibility['edit'] = false;

        return $this;
    }

    /**
     * Hide field when creating or updating a resource
     *
     * @var self
     */
    public function exceptOnForms() : self
    {
        //Reset the values
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
    public function onlyOnForms() : self
    {
        //Reset the values
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
    public function onlyOnIndex() : self
    {
        //Reset the values
        self::hideFromAll();

        $this->visibility['index'] = true;

        return $this;
    }

    /**
     * Show field only on show
     *
     * @var self
     */
    public function onlyOnShow() : self
    {
        //Reset the values
        self::hideFromAll();

        $this->visibility['show'] = true;

        return $this;
    }

    /**
     * Show field only on editing
     *
     * @var self
     */
    public function onlyOnEditing() : self
    {
        //Reset the values
        self::hideFromAll();

        $this->visibility['edit'] = true;

        return $this;
    }

    /**
     * Show field only on creating
     *
     * @var self
     */
    public function onlyOnCreating() : self
    {
        //Reset the values
        self::hideFromAll();

        $this->visibility['create'] = true;

        return $this;
    }

    /**
     * Field will be visible only on...
     *
     * @var self
     */
    public function visibleOn(...$attributes) : self
    {
        //Reset the values
        self::hideFromAll();

        foreach ($attributes as $attribute) {
            if (in_array($attribute, $this->allowedControllerActions)) {
                $this->visibility[$attribute] = true;
            }
        }

        return $this;
    }

    /**
     * Hide field only from...
     *
     * @var self
     */
    public function hideFrom(...$attributes) : self
    {
        foreach ($attributes as $attribute) {
            $this->visibility[$attribute] = false;
        }

        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Private methods
    |--------------------------------------------------------------------------
    */

    /**
     * Hide field for all actions
     *
     * @var void
     */
    protected function hideFromAll() : void
    {
        foreach ($this->visibility as $attribute => $value) {
            $this->visibility[$attribute] = false;
        }
    }

    /**
     * Show field for all actions
     *
     * @var void
     */
    protected function showInAll() : void
    {
        foreach ($this->visibility as $attribute => $value) {
            $this->visibility[$attribute] = true;
        }
    }
}
