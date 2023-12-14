<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterAction
{
    public function __invoke(array $input): User
    {
        $input['password'] = Hash::make($input['password']);

        return User::create($input);
    }
}
