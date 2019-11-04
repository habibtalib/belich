<?php

namespace Daguilarm\Belich\Components\Helpers;

use Carbon\Carbon;

trait Time
{
    /**
     * Set time for cookies
     *
     * @return int
     */
    private function setTimeForCookie(): int
    {
        return Carbon::now()->addYear()->timestamp;
    }
}
