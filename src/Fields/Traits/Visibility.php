<?php

namespace Daguilarm\Belich\Fields\Traits;

trait Visibility {

    /**
     * Field visibility base on the action
     *
     * @var array
     */
    public $showOn = [
        'index' => true,
        'create' => true,
        'edit' => true,
        'show' => true
    ];

    /**
     * Hide field from index
     *
     * @var void
     */
    public function hideFromIndex()
    {
        $this->showOn['index'] = false;

        return $this;
    }

    /**
     * Hide field when show a resource
     *
     * @var void
     */
    public function hideFromDetail()
    {
        $this->showOn['show'] = false;

        return $this;
    }

    /**
     * Hide field when creating a resource
     *
     * @var void
     */
    public function hideWhenCreating()
    {
        $this->showOn['create'] = false;

        return $this;
    }

    /**
     * Hide field when updating a resource
     *
     * @var void
     */
    public function hideWhenUpdating()
    {
        $this->showOn['edit'] = false;

        return $this;
    }

    /**
     * Hide field when creating or updating a resource
     *
     * @var void
     */
    public function exceptOnForms()
    {
        //Reset the values
        $this->hideAll();

        $this->showOn['index'] = true;
        $this->showOn['show'] = true;

        return $this;
    }

    /**
     * Show field only when creating or updating a resource
     *
     * @var void
     */
    public function onlyOnForms()
    {
        //Reset the values
        $this->hideAll();

        $this->showOn['create'] = true;
        $this->showOn['edit'] = true;

        return $this;
    }

    /**
     * Show field only on index
     *
     * @var void
     */
    public function onlyOnIndex()
    {
        //Reset the values
        $this->hideAll();

        $this->showOn['index'] = true;

        return $this;
    }

    /**
     * Show field only on detail
     *
     * @var void
     */
    public function onlyOnDetail()
    {
        //Reset the values
        $this->hideAll();

        $this->showOn['show'] = true;

        return $this;
    }

    /**
     * Show field only on...
     *
     * @var void
     */
    public function showOn(...$attributes)
    {
        //Reset the values
        $this->hideAll();

        foreach($attributes as $attribute) {
            $this->showOn[$attribute] = true;
        }

        return $this;
    }

    /**
     * Hide field only from...
     *
     * @var void
     */
    public function hideFrom(...$attributes)
    {
        foreach($attributes as $attribute) {
            $this->showOn[$attribute] = false;
        }

        return $this;
    }

    /**
     * Hide field for all...
     *
     * @var void
     */
    private function hideAll()
    {
        foreach($this->showOn as $attribute => $value) {
            $this->showOn[$attribute] = false;
        }
    }
}
