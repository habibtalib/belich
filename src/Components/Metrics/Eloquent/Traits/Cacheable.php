<?php

namespace Daguilarm\Belich\Components\Metrics\Eloquent\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

trait Cacheable
{
    /**
     * @var int
     */
    protected $cache;

    /**
     * @var bool
     */
    protected $cacheForEver = false;

    /**
     * @var string
     */
    protected $cacheKey;

    /**
     * Get data from cache
     *
     * @param string $dateType
     *
     * @return string
     */
    private function getDataFromCache(string $dateType): string
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
     *
     * @param string $dateType
     *
     * @return Illuminate\Support\Collection
     */
    private function parseCache($dateType): Collection
    {
        $cache = $this->getDataFromCache($dateType);

        return $cache instanceof Collection
            ? $cache
            : collect(json_decode($cache));
    }
}
