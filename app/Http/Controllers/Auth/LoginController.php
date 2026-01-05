<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {
        // Redirect based on role
        if ($user->isManager()) {
            return redirect()->route('manager.dashboard');
        } elseif ($user->isTeamLead()) {
            return redirect()->route('teamlead.dashboard');
        } elseif ($user->isIntern()) {
            return redirect()->route('employee.dashboard');
        } elseif ($user->isEmployee()) {
            return redirect()->route('employee.dashboard');
        } else {
            return redirect()->route('tasks.index');
        }
    }

    /**
     * The user has been logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(\Illuminate\Http\Request $request)
    {
        return redirect()->route('homepage');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
