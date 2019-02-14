<?php

/**
 * Create a @icon directive
 *
 * @return string
 */
Blade::directive('icon', function ($arguments) {
    $list = explode(',', str_replace(['(',')',' ', "'"], '', $arguments));
    $text = isset($list[1]) ? trans($list[1]) : '';

    return "<?php echo icon('$list[0]', '$text'); ?>";
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

/**
 * Create a @resolveField directive for the package
 *
 * @return string
 */
Blade::directive('resolveField', function ($arguments) {

    list($field, $data) = explode(',', $arguments.',');

    return "<?php echo namespace_path('Fields\\FieldResolve')::resolveField($field, $data); ?>";
});

/**
 * Create a @orderedLink directive for the package
 *
 * @return string
 */
Blade::directive('orderedLink', function ($arguments) {
    return "<?php echo namespace_path('Core\\Html')::orderedLink($arguments); ?>";
});
