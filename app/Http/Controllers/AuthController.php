<?php

namespace App\Http\Controllers;

use App\Actions\LoginAction;
use App\Actions\RegisterAction;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, RegisterAction $action): JsonResource
    {
        return UserResource::make($action($request->validated()));
    }

    /**
     * @throws AuthenticationException
     */
    public function login(LoginRequest $request, LoginAction $action): JsonResource
    {
        $user = $action($request->validated());

        return UserResource::make($user)->additional(['token' => $user->token]);
    }
}
