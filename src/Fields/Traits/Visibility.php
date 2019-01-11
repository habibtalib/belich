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
        'update' => true,
        'detail' => true
    ];


}
