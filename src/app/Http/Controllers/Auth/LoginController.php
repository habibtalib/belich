<?php

namespace Daguilarm\Belich\App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Daguilarm\Belich\Core\Belich;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * Class LoginController
 * @package App\Http\Controllers\Auth
 */
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        //Redirect to...
        $this->redirectTo = Belich::url();
    }

    /**
     * Set login view
     */
    public function showLoginForm()
    {
        return view('belich::auth.login');
    }
}
