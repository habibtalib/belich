<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Daguilarm\Belich\Core\Belich;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\View\View;

final class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');

        //Redirect to...
        $this->redirectTo = Belich::url();
    }

    /**
     * Set verify view
     */
    public function show(): View
    {
        return view('belich::auth.verify');
    }
}
