<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Components\Metrics\Eloquent\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

trait Cacheable
{
    /**
     * @var Carbon\Carbon
     */
    protected $cache;
    protected bool $cacheForEver = false;
    protected string $cacheKey;

    /**
     * Get data from cache
     */
    private function getDataFromCache(string $dateType): object
    {
        //Cache for ever
        if ($this->cacheForEver === true) {
            return Cache::rememberForever($this->cacheKey, function () use ($dateType) {
                return $this->getDataFromStorage($dateType);
            });
        }

        //Cache by time
        return Cache::remember($this->cacheKey, $this->cache, function () use ($dateType) {
            return $this->getDataFromStorage($dateType);
        });
    }

    /**
     * Parse cache
     */
    private function parseCache($dateType): Collection
    {
        $cache = $this->getDataFromCache($dateType);

        return $cache instanceof Collection
            ? $cache
            : collect(json_decode($cache));
    }
}
