<?php

namespace Daguilarm\Belich\Components\Metrics\Eloquent\Traits;

use Carbon\Carbon;

trait CacheForHumans
{
    /**
     * Set cache in seconds
     */
    public function cacheInSeconds(int $seconds, string $key): self
    {
        $this->cache = Carbon::now()->addSeconds($seconds);
        $this->initCacheKey($key);

        return $this;
    }

    /**
     * Set cache in minutes
     */
    public function cacheInMinutes(int $minutes, string $key): self
    {
        $this->cache = $minutes === 1
            ? Carbon::now()->addMinute()
            : Carbon::now()->addMinutes($minutes);

        $this->initCacheKey($key);

        return $this;
    }

    /**
     * Set cache in hours
     */
    public function cacheInHours(int $hours, string $key): self
    {
        $this->cache = $minutes === 1
            ? Carbon::now()->addHour()
            : Carbon::now()->addHours($hours);

        $this->initCacheKey($key);

        return $this;
    }

    /**
     * Set cache in days
     */
    public function cacheInDays(int $days, string $key): self
    {
        $this->cache = $minutes === 1
            ? Carbon::now()->addDay()
            : Carbon::now()->addDays($days);

        $this->initCacheKey($key);

        return $this;
    }

    /**
     * Set cache for ever
     */
    public function cacheForEver(string $key): self
    {
        $this->cacheForEver = true;
        $this->initCacheKey($key);

        return $this;
    }

    /**
     * Set cache key
     *
     * @param string $key
     *
     * @return  void
     */
    private function initCacheKey(string $key): void
    {
        $this->cacheKey = md5($key);
    }
}
