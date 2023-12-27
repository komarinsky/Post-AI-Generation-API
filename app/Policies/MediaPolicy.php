<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Media;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MediaPolicy
{
    public function update(User $user, Media $media): Response
    {
        if ($media->mediaable instanceof User && $user->id === $media->mediaable->id) {
            return Response::allow();
        }

        if ($media->mediaable instanceof Post && $user->id === $media->mediaable->user->id) {
            return Response::allow();
        }

        return Response::deny('You do not own this post.');
    }

    public function destroy(User $user, Media $media): Response
    {
        if ($user->role === UserRole::ADMIN
            || $media->mediaable instanceof User && $user->id === $media->mediaable->id) {
            return Response::allow();
        }

        if ($user->role === UserRole::ADMIN
            || $media->mediaable instanceof Post && $user->id === $media->mediaable->user->id) {
            return Response::allow();
        }

        return Response::deny('You do not own this post.');
    }
}
