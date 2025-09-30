<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Redirect users after login.
     */
    protected function redirectTo()
    {
        // If the logged-in user is an admin
        if (auth()->user()->role === 'admin') {
            return '/admin/dashboard';
        }

        // Otherwise, normal user
        return '/user/dashboard';
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
