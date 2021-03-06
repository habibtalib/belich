<?php

declare(strict_types=1);

Route::group(['middleware' => ['web']], static function (): void {

    // Authentication Routes...
    Route::get(Belich::path() . '/login', 'Daguilarm\Belich\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
    Route::post(Belich::path() . '/login', 'Daguilarm\Belich\Http\Controllers\Auth\LoginController@login');
    Route::post(Belich::path() . '/logout', 'Daguilarm\Belich\Http\Controllers\Auth\LoginController@logout')->name('logout');

    // Registration Routes...
    Route::get(Belich::path() . '/register', 'Daguilarm\Belich\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post(Belich::path() . '/register', 'Daguilarm\Belich\Http\Controllers\Auth\RegisterController@register');

    // Password Reset Routes...
    Route::get(Belich::path() . '/password/reset', 'Daguilarm\Belich\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post(Belich::path() . '/password/email', 'Daguilarm\Belich\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get(Belich::path() . '/password/reset/{token}', 'Daguilarm\Belich\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post(Belich::path() . '/password/reset', 'Daguilarm\Belich\Http\Controllers\Auth\ResetPasswordController@reset')->name('password.update');

    // Email Verification Routes...
    Route::get(Belich::path() . '/email/verify', 'Daguilarm\Belich\Http\Controllers\Auth\VerificationController@show')->name('verification.notice');
    Route::get(Belich::path() . '/email/verify/{id}', 'Daguilarm\Belich\Http\Controllers\Auth\VerificationController@verify')->name('verification.verify');
    Route::get(Belich::path() . '/email/resend', 'Daguilarm\Belich\Http\Controllers\Auth\VerificationController@resend')->name('verification.resend');
});
