<?php

/*
|--------------------------------------------------------------------------
| Resources helpers
|--------------------------------------------------------------------------
*/

/**
 * Get the resource settings
 *
 * @param array $settings
 * @param string $attribute
 * @return string
 */
if (!function_exists('resourceSettings')) {
    function resourceSettings(array $settings, string $attribute) : string
    {
        return $settings[$field] ?? null;
    }
}

/**
 * Get the resource setting label
 *
 * @param array $settings
 * @return string
 */
if (!function_exists('resourceSettingsLabel')) {
    function resourceSettingsLabel($settings = null) : string
    {
        if(!empty($settings)) {
            return resourceSettings($settings, 'label');
        }

        return ucfirst(getResourceName());
    }
}

/**
 * Get the resource setting plural label
 *
 * @param array $settings
 * @return string
 */
if (!function_exists('resourceSettingsPluralLabel')) {
    function resourceSettingsPluralLabel($settings = null) : string
    {
        if(!empty($settings)) {
            return resourceSettings($settings, 'labels');
        }

        return str_plural(resourceSettingsLabel());
    }
}

/**
 * Get the resource setting display on navigation
 *
 * @param array $settings
 * @return string
 */
if (!function_exists('resourceSettingsDisplayInNavigation')) {
    function resourceSettingsDisplayInNavigation($settings = null) : string
    {
        if(!empty($settings)) {
            return resourceSettings($settings, 'displayInNavigation');
        }

        return true;
    }
}
