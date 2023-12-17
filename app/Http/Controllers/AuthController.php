<?php

namespace App\Http\Controllers;

use App\Actions\LoginAction;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthController extends Controller
{
    /**
     * @throws AuthenticationException
     */
    public function login(LoginRequest $request, LoginAction $action): JsonResource
    {
        $user = $action($request->validated());

        return UserResource::make($user)->additional(['token' => $user->token]);
    }
}
