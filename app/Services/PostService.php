<?php

namespace App\Services;

use App\Models\Post;
use App\QueryBuilders\SortByMostLikeable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

final class PostService
{
    public function store(array $input): Post
    {
        if (! $input['description']) {
            $input['description'] = (new ArticleService())->generateArticle($input['title']);
        }

        return Auth::user()->posts()->create($input);
    }

    public function update(Post $post, array $input): Post
    {
        $post->update($input);

        return $post->fresh();
    }

    public function getList(): LengthAwarePaginator
    {
        $mostLikeable = AllowedSort::custom('most-likeable', new SortByMostLikeable());

        return QueryBuilder::for(Post::class)
            ->allowedFilters([
                AllowedFilter::scope('search'),
            ])
            ->allowedSorts($mostLikeable)
            ->with(['user'])
            ->withLikes()
            ->paginate(request()->per_page);
    }
}
