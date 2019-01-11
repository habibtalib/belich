<?php

/**
 * Create a @mix directive for the package namespace
 *
 * @return string
 */
Blade::directive('mix', function ($expression) {
    if (ends_with($expression, ".css'")) {
        return '<link rel="stylesheet" href="<?php echo mix('.$expression.', \'vendor/belich\') ?>">';
    }

    if (ends_with($expression, ".js'")) {
        return '<script src="<?php echo mix('.$expression.', \'vendor/belich\') ?>"></script>';
    }

    return "<?php echo mix({$expression}); ?>";
});

/**
 * Create a @trans directive for the package localization's files
 *
 * @return string
 */
Blade::directive('trans', function ($expression) {
    return e(trans('belich::' . str_replace("'", '', $expression)));
});