<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getMe(): JsonResource
    {
        return UserResource::make(Auth::user());
    }

    public function index(): JsonResource
    {
        return UserResource::collection(User::paginate());
    }

    public function show(User $user): JsonResource
    {
        return UserResource::make($user->load(['posts']));
    }
}
