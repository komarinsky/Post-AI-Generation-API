<?php

namespace App\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

final class SortByMostLikeable implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $query->withLikes()->orderByDesc('likes_count');
    }
}
