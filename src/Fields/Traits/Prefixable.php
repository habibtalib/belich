<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Traits;

trait Prefixable
{
    public ?string $prefix = null;
    public ?string $suffix = null;

    /**
     * Prefix for field value
     */
    public function prefix(?string $prefix, bool $space = false): self
    {
        if ($prefix) {
            $this->displayUsing(static function ($value) use ($prefix, $space) {
                return sprintf(
                    '%s%s%s',
                    $prefix, $space ? ' ' : '',
                    $value
                );
            });
        }

        return $this;
    }

    /**
     * Suffix for field value
     */
    public function suffix(?string $suffix, bool $space = false): self
    {
        if ($suffix) {
            $this->displayUsing(static function ($value) use ($suffix, $space) {
                return sprintf(
                    '%s%s%s',
                    $value,
                    $space ? ' ' : '',
                    $suffix
                );
            });
        }

        return $this;
    }
}
