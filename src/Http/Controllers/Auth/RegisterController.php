<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Daguilarm\Belich\Core\Belich;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

final class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('guest');

        //Redirect to...
        $this->redirectTo = Belich::url();
    }

    /**
     * Set register view
     */
    public function showRegistrationForm(): View
    {
        return view('belich::auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     */
    protected function validator(array $data): Validator
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     */
    protected function create(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
