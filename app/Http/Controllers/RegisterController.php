<?php

namespace App\Http\Controllers;

use App\Http\Requests\Register\RegisterUserRequest;
use App\Http\Requests\Register\ResendEmailRequest;
use App\Http\Resources\UserResource;
use App\Services\Contracts\RegisterUserInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisterController extends Controller
{
    public function __construct(
        private readonly RegisterUserInterface $service,
    ) {}

    public function register(RegisterUserRequest $request): JsonResource
    {
        return UserResource::make($this->service->register($request->validated()));
    }

    /**
     * @throws AuthenticationException
     */
    public function verify(Request $request, $user_id): RedirectResponse
    {
        if (!$request->hasValidSignature()) {
            throw new AuthenticationException();
        }

        $this->service->verify($user_id);

        return redirect()->to('/');
    }

    public function reSend(ResendEmailRequest $request)
    {
        $this->service->reSend($request->email);
    }
}
