<?php

namespace App\Services;

use App\Jobs\SendRegistrationEmail;
use App\Models\User;
use App\Services\Contracts\RegisterUserInterface;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use League\CommonMark\Exception\AlreadyInitializedException;

final class RegisterUserEmailService implements RegisterUserInterface
{
    public function register(array $input): User
    {
        $input['password'] = Hash::make($input['password']);

        $user = User::query()->create($input);

        SendRegistrationEmail::dispatch($user);

        return $user;
    }

    public function reSend(string $email): void
    {
        $user = User::whereEmail($email)->firstOrFail();

        if ($user->hasVerifiedEmail()) {
            throw new AlreadyInitializedException();
        }

        SendRegistrationEmail::dispatch($user);
    }

    public function verify(int|string $userId): void
    {
        $user = User::findOrFail($userId);

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }
    }
}
