<?php

/**
 * Recursive get method with dot notation
 *
 * @return mixed
 */
\Illuminate\Support\Collection::macro('getValue', function ($dotNotation) {
    return data_get($this, $dotNotation);
});
