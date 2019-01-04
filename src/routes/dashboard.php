<?php

Route::get('/belich/dashboard', 'DashboardController@index')
    ->name('belich')
    ->middleware('web');
