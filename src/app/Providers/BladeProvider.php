<?php

/**
 * Create a @icon directive
 *
 * @return string
 */
Blade::directive('actionIcon', function ($arguments) {
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
        ? 'block h-10 rounded-full shadow'
        : $arguments;

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

    return "<?php echo icon('$list[0]', '$text', '$css'); ?>";
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
