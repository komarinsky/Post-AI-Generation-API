<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;

class LoginAction
{
    /**
     * @throws AuthenticationException
     */
    public function __invoke(array $input): User
    {
        $user = User::query()
            ->where('email', $input['email'])
            ->first();

        if (! Hash::check($input['password'], $user->password)) {
            throw new AuthenticationException();
        }

        $user->token = $user->createToken('auth')->plainTextToken;

        return $user;
    }
}
