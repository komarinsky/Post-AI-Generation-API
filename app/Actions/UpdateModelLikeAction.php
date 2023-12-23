<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Model;

final class UpdateModelLikeAction
{
    public function __invoke(Model $model): int
    {
        $liked = $model->likes->first(fn($like) => $like->user_id === auth()->id());

        $liked ? $liked->delete() : $model->likes()->create(['user_id' => auth()->id()]);

        return $model->likes()->count();
    }
}
