<?php

namespace Daguilarm\Belich\Fields\FieldTraits;

trait Visibilities {

    /**
     * Field visibility base on the action
     *
     * @var array
     */
    private $alowedActions = ['index', 'create', 'edit', 'show'];

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
        $this->hideAllActions();

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
        $this->hideAllActions();

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
        $this->hideAllActions();

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
        $this->hideAllActions();

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
        $this->hideAllActions();

        foreach($attributes as $attribute) {
            if(in_array($attribute, $this->alowedActions)) {
                $this->showOn[$attribute] = true;
            }
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
     * Show field on all actions
     *
     * @var void
     */
    private function ShowAllActions()
    {
        foreach($this->showOn as $attribute => $value) {
            $this->showOn[$attribute] = true;
        }
    }

    /**
     * Hide field for all actions
     *
     * @var void
     */
    private function hideAllActions()
    {
        foreach($this->showOn as $attribute => $value) {
            $this->showOn[$attribute] = false;
        }
    }
}
