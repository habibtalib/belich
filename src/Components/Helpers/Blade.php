<?php

namespace Daguilarm\Belich\Components\Helpers;

trait Blade
{
    /**
     * Hide content base on screen size
     *
     * @param array $hideFor
     *
     * @return string
     */
    public function hideContainerForScreens(array $hideFor): string
    {
        $screens = collect(['sm', 'md', 'lg', 'xl']);

        return $screens
            ->map(static function ($size) use ($hideFor) {
                $status = in_array($size, $hideFor) ? 'hidden' : 'flex';
                return sprintf('%s:%s', $size, $status);
            })
            ->filter()
            ->prepend('hidden')
            ->implode(' ');
    }

    /**
     * Hide cards base on screen size
     *
     * @param object $request
     *
     * @return string
     */
    public function hideCardsForScreens(): string
    {
        return self::hideContainerForScreens(config('belich.hideCardsForScreens'));
    }

    /**
     * Hide metrics base on screen size
     *
     * @param object $request
     *
     * @return string
     */
    public function hideMetricsForScreens(): string
    {
        return self::hideContainerForScreens(config('belich.hideMetricsForScreens'));
    }
}
