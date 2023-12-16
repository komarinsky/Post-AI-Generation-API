<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

final class PostService
{
    public function create(array $input): Post
    {
        return Auth::user()->posts()->create($input);
    }

    public function update(Post $post, array $input): Post
    {
        $post->update($input);

        return $post->fresh();
    }

    public function getList()
    {
        return Post::paginate(request()?->per_page);
    }
}
