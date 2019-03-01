<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Facades\Belich;
use Daguilarm\Belich\Fields\Field;

class Custom extends Field {

    /**
     * Field type
     *
     * @var string
     */
    public $type = 'custom';

    /** @var string */
    public $view;

    /**
     * Create a new field.
     *
     * @param  string|null  $name
     * @param  string|null  $view
     */
    public function __construct($name = null, $view = null)
    {
        parent::__construct($name, $view);

        $this->view = $view;
    }
}
