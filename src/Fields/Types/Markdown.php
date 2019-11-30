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
}
