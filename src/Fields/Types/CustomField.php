<?php

namespace Daguilarm\Belich\Fields\Types;

class CustomField
{
    /**
     * @var string
     */
    public $type = 'custom';

    /**
     * @var string
     */
    public $view;

    /**
     * Init custom field
     */
    public function __construct()
    {
        $this->view = view(app_path('Belich\Components\\' . get_class($this) .'\view'));
    }
}
