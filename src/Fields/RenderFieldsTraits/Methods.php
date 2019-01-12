<?php

namespace Daguilarm\Belich\Fields\RenderFieldsTraits;

trait Methods {

    /**
     * Just for know the origin of the method
     *
     * @return array
     */
    public function basePath()
    {
        return $this;
    }

    /**
     * Generate the field object
     *
     * @return array
     */
    public function getFields()
    {
        $fields = $this->basePath('Current\Resource\Path')
            ->resourceClass
            ->fields($this->request);

        return self::showOrHide($fields);
    }

    /**
     * Show or Hide field base on actions
     *
     * @param object $fields
     * @return array
     */
    public function showOrHide($fields)
    {
        return collect($fields)
            ->map(function($field) {
                return $field->showOn[$this->action] ? $field : null;
            })
            ->filter();
    }
}
