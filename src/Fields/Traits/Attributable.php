<?php

namespace Daguilarm\Belich\Fields\Traits;

trait Attributable {

    /** @var array [Add new css classes to the current field] */
    public $addClass;

    /** @var string [Add to field the autofocus attribute] */
    public $autofocus;

    /** @var array [Generate de data attributes] */
    public $data;

    /** @var bool [Disabled field] */
    public $disabled = false;

    /** @var bool [Read only field] */
    public $readonly = false;

    /**
     * Add new css classes to the current field
     *
     * @return self
     */
    public function addClass(...$values) : self
    {
        $this->addClass = implode(' ', $values);

        return $this;
    }

    /**
     * Add to field the autofocus attribute
     *
     * @return self
     */
    public function autofocus() : self
    {
        $this->autofocus = true;

        return $this;
    }

    /**
     * Set data attributes
     *
     * @return self
     */
    public function data($attribute, $value) : self
    {
        $this->data[] = [$attribute, $value];

        return $this;
    }

    /**
     * Set the field with the attribute 'disabled'
     *
     * @param  bool  $value
     * @return self
     */
    public function disabled(bool $value = true) : self
    {
        if(!empty($value)) {
            $this->disabled = true;
        }

        return $this;
    }

    /**
     * Set the field default value
     *
     * @param  string|null  $value
     * @return self
     */
    public function defaultValue($value = null) : self
    {
        //Check the value for conditional cases...
        if(!empty($value)) {
            $this->value = $value;
        }

        return $this;
    }

    /**
     * Set the field with the attribute 'readonly'
     *
     * @param  bool  $value
     * @return self
     */
    public function readOnly(bool $value = true) : self
    {
        if(!empty($value)) {
            $this->readonly = true;
        }

        return $this;
    }
}
