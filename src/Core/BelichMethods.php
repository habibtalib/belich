<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Core;

use Daguilarm\Belich\Core\BelichResources;
use Illuminate\Support\Str;

abstract class BelichMethods extends BelichResources
{
    /**
     * Set the class name
     */
    public static function classFormat(string $className): string
    {
        return Str::title(Str::singular($className));
    }

    /**
     * Set the class name
     */
    public static function className(): string
    {
        $result = request()->query('resourceName') ?? static::resourceName();

        return static::classFormat($result);
    }

    /**
     * Get the current resource form action (to Controller)
     */
    public static function controllerAction(?string $className = null): ?string
    {
        $class = static::resourceClassPath();

        return $class::$controllerAction ?? null;
    }

    /**
     * Count the total results
     */
    public static function count($value, int $initialValue = 0): int
    {
        if (is_array($value)) {
            return count($value) + $initialValue;
        }

        if (is_object($value)) {
            return $value->count() + $initialValue;
        }

        return 0;
    }

    /**
     * Get the resource $downloable variable.
     */
    public static function downloable(): bool
    {
        $class = static::resourceClassPath();

        return $class::$downloable;
    }

    /**
     * Get the resource md5 key
     */
    public static function key(): string
    {
        return md5(static::resource());
    }

    /**
     * Get the resource $redirectTo variable.
     */
    public static function redirectTo(): string
    {
        $class = static::resourceClassPath();

        return $class::$redirectTo;
    }
}
