<?php

/*
|--------------------------------------------------------------------------
| Define your coustom routes
|--------------------------------------------------------------------------
*/

//Dashboard route
Route::get(Belich::path(), function() {
    return view('belich::pages.dashboard');
});
