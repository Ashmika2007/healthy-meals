<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class CustomLoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        // Get the logged-in user
        $user = $request->user();

        // Redirect everyone to the homepage for now
        return redirect('/');
    }
}
