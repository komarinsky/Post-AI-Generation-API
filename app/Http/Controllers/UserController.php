<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getMe(): UserResource
    {
        return UserResource::make(Auth::user());
    }
}
