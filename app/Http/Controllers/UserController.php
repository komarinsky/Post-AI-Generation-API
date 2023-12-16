<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getMe(): UserResource
    {
        return UserResource::make(Auth::user());
    }

    public function index()
    {
        $users = User::with('posts')->paginate();

        return UserResource::collection($users);
    }
}
