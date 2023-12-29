<?php

namespace App\Observers;

use App\Models\Media;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewMediaNotification;

class MediaObserver
{
    /**
     * Handle the Media "created" event.
     */
    public function created(Media $media): void
    {
        $this->sendNotification($media);
    }

    private function sendNotification(Media $media): void
    {
        if ($media->mediaable instanceof User) {
            $media->mediaable->notify(new NewMediaNotification($media));
        }

        if ($media->mediaable instanceof Post) {
            $media->mediaable->user->notify(new NewMediaNotification($media));
        }
    }
}
