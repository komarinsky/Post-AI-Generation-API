<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

final class LoginAction
{
    /**
     * @throws AuthenticationException
     */
    public function __invoke(): User
    {
        if (Auth::attempt(request()->only('email', 'password'))) {
            Auth::user()->token = Auth::user()->createToken('auth')->plainTextToken;
        }

        return Auth::user();
    }
}
