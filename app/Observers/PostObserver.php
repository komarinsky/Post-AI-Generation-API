<?php

namespace App\Observers;

use App\Events\NewPostEvent;
use App\Models\Post;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        broadcast(new NewPostEvent($post));
    }
}
