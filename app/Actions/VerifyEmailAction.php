<?php

namespace App\Actions;

use App\Models\User;

final class VerifyEmailAction
{
    public function __invoke(int $userId): void
    {
        $user = User::findOrFail($userId);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }
    }
}
