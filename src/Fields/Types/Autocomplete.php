<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

class Autocomplete extends Field {

    /** @var string */
    public $type = 'autocomplete';

    /** @var string */
    public $ajaxUrl;

    /**
     * Set the ajax Url.
     *
     * @param  string  $url
     * @return self
     */
    private function ajaxUrl(string $url) : self
    {
        $this->ajaxUrl = $url;

        return $this;
    }
}
