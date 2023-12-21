<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    public function update(User $user, Post $post): Response
    {
        return $user->id === $post->user_id
            ? Response::allow()
            : Response::deny('You do not own this post.');
    }

    public function destroy(User $user, Post $post): Response
    {
        return $user->id === $post->user_id || $user->role === UserRole::ADMIN
            ? Response::allow()
            : Response::deny('You do not own this post.');
    }
}
