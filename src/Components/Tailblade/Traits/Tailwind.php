<?php

namespace Daguilarm\Belich\Components\Tailblade\Traits;

trait Tailwind {

    /*
    |--------------------------------------------------------------------------
    | Tailwindcss methods
    |--------------------------------------------------------------------------
    */

    /**
     * Generate the margin
     *
     * @param string $direction
     * @param int $value
     * @return self
     */
    public function margin($direction, int $value = 0) : self
    {
        $this->classes[] = $this->withDirection($direction, $value, $type = 'm');

        return $this;
    }

    /**
     * Generate the padding
     *
     * @param string $direction
     * @param int $value
     * @return self
     */
    public function padding($direction, int $value = 0) : self
    {
        $this->classes[] = $this->withDirection($direction, $value, $type = 'p');

        return $this;
    }

    /**
     * Generate the text color
     *
     * @param array $arg
     * @return self
     */
    public function color(...$arg) : self
    {
        $this->classes[] = $this->getColor('text', ...$arg);

        return $this;
    }

    /**
     * Generate the background color
     *
     * @param array $arg
     * @return self
     */
    public function background(...$arg) : self
    {
        $this->classes[] = $this->getColor('bg', ...$arg);

        return $this;
    }

    /**
     * Generate the border radius
     *
     * @param string $direction
     * @param int $value
     * @return self
     */
    public function radius(string $direction, int $value = 0) : self
    {
        //Set direction
        $pointer = in_array($direction, $this->getConfig('spacing.directions'))
            ? substr($direction, 0, 1)
            : '';

        //Set value
        $quantity = ($value <= 0 && is_numeric($direction))
            ? $this->getConfig('radius.size', $direction)
            : $this->getConfig('radius.size', $value);

        //Without direction
        if($value <= 0 && is_int($direction)) {
            $this->classes[] = sprintf('rounded-%s', $quantity);
        }

        //With direction
        $this->classes[] = sprintf('rounded-%s-%s', $pointer, $quantity);

        return $this;
    }

    /**
     * Generate the text size
     *
     * @param int $number
     * @return self
     */
    public function size(int $number) : self
    {
        $this->classes[] = 'text-' . $this->getConfig('font.size', $number);

        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Tailwindcss helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Generate the spacing values: margin and padding
     *
     * @param string $direction
     * @param int $value
     * @param string $type
     * @return string
     */
    private function withDirection(string $direction, int $value = 0, string $type) : string
    {
        //Set direction
        $pointer = in_array($direction, $this->getConfig('spacing.directions'))
            ? substr($direction, 0, 1)
            : '';

        //Set value
        $quantity =  ($value <= 0 && is_numeric($direction))
            ? $direction
            : $value;

        //Without direction
        if($value <= 0 && is_int($direction)) {
            return sprintf('%s-%s', $type, $quantity);
        }

        //With direction
        return sprintf('%s%s-%s', $type, $pointer, $quantity);
    }

    /**
     * Generate the color values: text-color and bg-color
     *
     * @param string $type
     * @param array $arg
     * @return string
     */
    private function getColor(string $type, ...$arg) : string
    {
        return collect($arg)
            ->map(function($value) {
                return $value;
            })
            ->prepend($type)
            ->filter()
            ->implode('-');
    }
}
