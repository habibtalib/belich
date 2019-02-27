<?php

/**
 * Create a @icon directive
 *
 * @return string
 */
Blade::directive('actionIcon', function ($arguments) {
    //App\Http\Helpers\Icons.php
    return "<?php echo actionIcon($arguments); ?>";
});

/**
 * Create a @gravatar directive for the package gravatar
 *
 * @return string
 */
Blade::directive('gravatar', function ($arguments) {
    $arguments = str_replace(['(',')', "'"], '', $arguments);
    $css = empty($arguments)
        ? 'block h-10 rounded-full shadow-md'
        : $arguments;

    //App\Http\Helpers\Icons.php
    return "<?php echo '" . sprintf('<img class="%s" src="%s" alt="">', $css, gravatar()) . "'; ?>";
});

/**
 * Create a @icon directive
 *
 * @return string
 */
Blade::directive('icon', function ($arguments) {
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
Blade::directive('listTextFromArray', function ($arguments) {
    $text = explode(',', str_replace(['(',')',' ', "'"], '', $arguments));
    $list = collect(trans($text[0]))
        ->map(function($item) {
            return sprintf('<div>%s</div>', icon('check-square', $item));
        })
        ->implode('');

    //App\Http\Helpers\Icons.php
    return "<?php echo '$list'; ?>";
});

/**
 * Create a Blade if directive for @hasSoftdelete
 * Check if a model has the softdelete trait
 *
 * @return string
 */
Blade::if('hasSoftdelete', function ($model) {
    //App\Http\Helpers\Models.php
    return hasSoftdelete($model);
});

/**
 * Create a Blade if directive for @isTrashed
 * Check if a model has softdeleted results
 *
 * @return string
 */
Blade::if('hasSoftdeletedResults', function ($model) {
    //App\Http\Helpers\Models.php
    return hasSoftdeletedResults($model);
});

/**
 * Create a @mix directive for the package namespace
 *
 * @return string
 */
Blade::directive('mix', function ($arguments) {
    if (ends_with($arguments, ".css'")) {
        return '<link rel="stylesheet" href="<?php echo mix('.$arguments.', \'vendor/belich\') ?>">';
    }
    if (ends_with($arguments, ".js'")) {
        return '<script src="<?php echo mix('.$arguments.', \'vendor/belich\') ?>"></script>';
    }

    return "<?php echo mix({$arguments}); ?>";
});

/**
 * Create a @trans directive for the package localization's files
 *
 * @return string
 */
Blade::directive('trans', function ($arguments) {
    return e(trans('belich::' . str_replace("'", '', $arguments)));
});
