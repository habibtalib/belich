<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

class Select extends Field
{
    /**  @var string */
    public $type = 'select';

    /**  @var bool */
    public $displayUsingLabels;

    /** @var array */
    public $options;

    /**
     * Display using labels
     *
     * @return self
     */
    public function displayUsingLabels(): self
    {
        $this->displayUsingLabels = true;

        return $this;
    }

    /**
     * Add option values to the select
     *
     * @param array $options
     *
     * @return self
     */
    public function options(array $options = []): self
    {
        //Check the text for conditional cases...
        if (!empty($options)) {
            $this->options = ['' => ''] + $options;
        }

        return $this;
    }
}
