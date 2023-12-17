<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

final class RegisterAction
{
    public function __invoke(array $input): User
    {
        $input['password'] = Hash::make($input['password']);

        $user = User::query()->create($input);

        event(new Registered($user));

        return $user;
    }
}
