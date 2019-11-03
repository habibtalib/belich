<?php

namespace Daguilarm\Belich\Components\Metrics\Eloquent\Traits;

use Daguilarm\Belich\Components\Metrics\Eloquent\Traits\CacheForHumans;
use Illuminate\Support\Facades\Cache;

trait Cacheable
{
    use CacheForHumans;

    /** @var int */
    protected $cache;

    /** @var bool */
    protected $cacheForEver = false;

    /** @var string */
    protected $cacheKey;

    /**
     * Get data from cache
     *
     * @param string $dateType
     * @param string $type
     *
     * @return string
     */
    private function getDataFromCache(string $dateType, string $type): string
    {
        //Cache for ever
        if ($this->cacheForEver === true) {
            return Cache::rememberForever($this->cacheKey, function () use ($dateType, $type) {
                return $this->getDataFromStorage($dateType, $type);
            });
        }

        //Cache by time
        return Cache::remember($this->cacheKey, $this->cache, function () use ($dateType, $type) {
            return $this->getDataFromStorage($dateType, $type);
        });
    }
}
