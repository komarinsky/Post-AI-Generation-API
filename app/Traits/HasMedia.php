<?php

namespace App\Traits;

use App\Models\Like;
use App\Models\Media;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasMedia
{
    public function scopeWithMedia(Builder $query): void
    {
        $query->with('media');
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediaable');
    }
}
