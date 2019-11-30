<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Types\TextArea;

final class Markdown extends TextArea
{
    /**
     * @var string
     */
    public $asHtml = true;

    /**
     * @var string
     */
    public $markdown = true;

    /**
     * Create a new field
     *
     * @param  string  $name
     * @param  string|null  $attribute
     *
     * @return  void
     */
    public function __construct($label, $attribute = null)
    {
        //Set the values
        parent::__construct($label, $attribute);

        //Cast the field as string
        $this->hideFromIndex();
    }
}
