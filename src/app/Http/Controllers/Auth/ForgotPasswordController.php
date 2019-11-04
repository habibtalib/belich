<?php

namespace Daguilarm\Belich\App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Daguilarm\Belich\Core\Belich;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\View\View;

final class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Set forgot password view
     *
     * @return  Illuminate\View\View
     */
    public function showLinkRequestForm(): View
    {
        return view('belich::auth.passwords.email');
    }
}
