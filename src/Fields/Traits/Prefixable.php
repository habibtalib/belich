<?php

namespace Daguilarm\Belich\Fields\Traits;

trait Prefixable
{
    /**
     * Prefix for field value
     *
     * @var string
     */
    public $prefix;

    /**
     * Suffix for field value
     *
     * @var string
     */
    public $suffix;

    /**
     * Prefix for field value
     *
     * @param  string  $prefix
     * @param  bool  $space
     *
     * @return self
     */
    public function prefix(string $prefix, bool $space = false): self
    {
        $this->displayUsing(static function ($value) use ($prefix, $space) {
            return sprintf(
                '%s%s%s',
                $prefix, $space ? ' ' : '',
                $value
            );
        });

        return $this;
    }

    /**
     * Suffix for field value
     *
     * @param  string  $suffix
     * @param  bool  $space
     *
     * @return self
     */
    public function suffix(string $suffix, bool $space = false): self
    {
        $this->displayUsing(static function ($value) use ($suffix, $space) {
            return sprintf(
                '%s%s%s',
                $value,
                $space ? ' ' : '',
                $suffix
            );
        });

        return $this;
    }
}
