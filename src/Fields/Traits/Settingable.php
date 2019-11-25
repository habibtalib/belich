<?php

namespace Daguilarm\Belich\Fields\Traits;

use Daguilarm\Belich\Facades\Helper;

trait Settingable
{
    /**
     * List of allowed controller actions
     *
     * @var array
     */
    public $allowedControllerActions = [
        'index',
        'create',
        'edit',
        'show',
    ];

    /**
     * The custom breadcrumbs for the field
     *
     * @var string
     */
    public $breadcrumbs;

    /**
     * @var string
     */
    public $dusk;

    /**
     * @var int
     */
    public $id;

    /**
     * Set the field label tag
     *
     * @var string
     */
    public $label;

    /**
     * @var string
     */
    public $name;

    /**
     * Indicates if the field should be sortable
     *
     * @var bool
     */
    public $sortable = false;

    /**
     * Set the attribute dusk
     *
     * @param  string|null  $value
     *
     * @return self
     */
    public function dusk($value = null): self
    {
        //Check the value for conditional cases...
        if (isset($value)) {
            $this->dusk = $value;
        }

        return $this;
    }

    /**
     * Set the attribute id
     *
     * @param  string|null  $value
     *
     * @return self
     */
    public function id($value = null): self
    {
        //Check the value for conditional cases...
        if (isset($value)) {
            $this->id = Helper::stringSanitize($value);
        }

        return $this;
    }

    /**
     * Set the attribute name
     *
     * @param  string|null  $value
     *
     * @return self
     */
    public function name($value = null): self
    {
        //Check the value for conditional cases...
        if (isset($value)) {
            $this->name = $value;
        }

        return $this;
    }

    /**
     * Set the field sortable
     *
     * @return self
     */
    public function sortable(): self
    {
        $this->sortable = true;

        return $this;
    }
}
