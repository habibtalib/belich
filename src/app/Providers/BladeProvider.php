<?php

use Illuminate\Support\Str;

/**
 * Create a @icon directive
 *
 * @return string
 */
Blade::directive('actionIcon', static function ($arguments) {
    //App\Http\Helpers\Icons.php
    return "<?php echo actionIcon($arguments); ?>";
});

/**
 * Create a @icon directive
 *
 * @return string
 */
Blade::directive('icon', static function ($arguments) {
    $list = explode(',', str_replace(['(',')',' ', "'"], '', $arguments));
    $text = isset($list[1]) ? trans($list[1]) : '';
    $css = isset($list[2]) ? $list[2] : '';

    //App\Http\Helpers\Icons.php
    return "<?php echo icon('$list[0]', '$text', '$css'); ?>";
});

/**
 * Create a @listTextFromArray directive
 * It is created for modal or menssages, when there is a array with texts!
 *
 * @return string
 */
Blade::directive('listTextFromArray', static function ($arguments) {
    $text = explode(',', str_replace(['(',')',' ', "'"], '', $arguments));
    $list = collect(trans($text[0]))
        ->map(static function ($item) {
            return sprintf('<div>%s</div>', icon('check-square', $item));
        })
        ->implode('');

    //App\Http\Helpers\Icons.php
    return "<?php echo '$list'; ?>";
});

/**
 * Create a Blade if directive for @hasMetrics
 * Check if a request has a metric to show
 *
 * @return string
 */
Blade::if('hasMetrics', static function ($request) {
    //App\Http\Helpers\Blade.php
    return hasMetrics($request);
});

/**
 * Create a Blade if directive for @hasSoftdelete
 * Check if a model has the softdelete trait
 *
 * @return string
 */
Blade::if('hasSoftdelete', static function ($model) {
    //App\Http\Helpers\Models.php
    return hasSoftdelete($model);
});

/**
 * Create a Blade if directive for @isTrashed
 * Check if a model has softdeleted results
 *
 * @return string
 */
Blade::if('hasSoftdeletedResults', static function ($model) {
    //App\Http\Helpers\Models.php
    return hasSoftdeletedResults($model);
});

/**
 * Create a @mix directive for the package namespace
 *
 * @return string
 */
Blade::directive('mix', static function ($arguments) {
    $path = '/vendor/belich/' . str_replace("'", '', $arguments) . '?v=' . Str::random(20);

    if (Str::endsWith($arguments, ".css'")) {
        return '<link rel="stylesheet" href="' . $path . '" media="all">';
    }
    if (Str::endsWith($arguments, ".js'")) {
        return '<script src="' . $path . '"></script>';
    }

    return $path;
});

/**
 * Create a @trans directive for the package localization's files
 *
 * @return string
 */
Blade::directive('trans', static function ($arguments) {
    return e(trans('belich::' . str_replace("'", '', $arguments)));
});
