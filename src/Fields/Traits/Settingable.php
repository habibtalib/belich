<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Traits;

use Daguilarm\Belich\Facades\Helper;

trait Settingable
{
    public string $dusk;
    public string $id;
    public string $name;
    public bool $sortable = false;
    public string $uriKey;

    /**
     * Set the attribute dusk
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
     */
    public function sortable(): self
    {
        $this->sortable = true;

        return $this;
    }
}
