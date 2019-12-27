<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

final class Select extends Field
{
    /**
     * @var string
     */
    public $type = 'select';

    /**
     * @var bool
     */
    public $displayUsingLabels;

    /**
     * @var array
     */
    public $firstOption;

    /**
     * @var array
     */
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
        if (isset($options)) {
            $this->options = $options;
        }

        return $this;
    }

    /**
     * Add the first option to the select
     *
     * @param array $options
     *
     * @return self
     */
    public function firstOption(string $title = '', string $value = ''): self
    {
        //Check the text for conditional cases...
        $this->firstOption = [$title, $value];

        return $this;
    }
}
