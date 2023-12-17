<?php

namespace App\Services\Contracts;

interface RegisterUserInterface
{
    public function register(array $input);

    public function verify(int|string $userId);

    public function reSend(string $email);
}
