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
     * @var string
     */
    public $filter = 'equal';

    /**
     * @var string
     */
    public $filterDate;

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
     * Set the search filter type
     *
     * @param string $value
     *
     * @return self
     */
    public function filter(string $value): self
    {
        $this->filter = $value;

        return $this;
    }

    /**
     * Set the search filter for date
     *
     * @param string $value
     *
     * @return self
     */
    public function filterDate(string $format): self
    {
        $this->filter = 'date';
        $this->filterDate = $format;

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
