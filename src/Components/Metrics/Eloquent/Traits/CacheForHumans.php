<?php

namespace Daguilarm\Belich\Components\Metrics\Eloquent\Traits;

use Carbon\Carbon;

trait CacheForHumans
{
    /**
     * Set cache in seconds
     */
    public function cacheInSeconds(int $seconds, string $key)
    {
        $this->cache = Carbon::now()->addSeconds($seconds);
        $this->cacheKey = md5($key);

        return $this;
    }

    /**
     * Set cache in minutes
     */
    public function cacheInMinutes(int $minutes, string $key)
    {
        if ($minutes === 1) {
            $this->cache = Carbon::now()->addMinute();
        } else {
            $this->cache = Carbon::now()->addMinutes($minutes);
        }

        $this->cacheKey = md5($key);

        return $this;
    }

    /**
     * Set cache in hours
     */
    public function cacheInHours(int $hours, string $key)
    {
        if ($minutes === 1) {
            $this->cache = Carbon::now()->addHour();
        } else {
            $this->cache = Carbon::now()->addHours($hours);
        }

        $this->cacheKey = md5($key);

        return $this;
    }

    /**
     * Set cache in days
     */
    public function cacheInDays(int $days, string $key)
    {
        if ($minutes === 1) {
            $this->cache = Carbon::now()->addDay();
        } else {
            $this->cache = Carbon::now()->addDays($days);
        }

        $this->cacheKey = md5($key);

        return $this;
    }

    /**
     * Set cache for ever
     */
    public function cacheForEver(string $key)
    {
        $this->cacheForEver = true;
        $this->cacheKey = md5($key);

        return $this;
    }
}
