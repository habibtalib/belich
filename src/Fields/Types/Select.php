<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

class Select extends Field
{
    public string $type = 'select';
    public bool $displayUsingLabels = false;
    public array $firstOption;
    public array $options = [];

    /**
     * Display using labels
     */
    public function displayUsingLabels(): self
    {
        $this->displayUsingLabels = true;

        return $this;
    }

    /**
     * Add option values to the select
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
     */
    public function firstOption($title = '', $value = ''): self
    {
        //Check the text for conditional cases...
        $this->firstOption = [$title, $value];

        return $this;
    }
}
