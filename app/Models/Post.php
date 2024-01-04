<?php

namespace App\Models;

use App\Traits\HasLikes;
use App\Traits\HasMedia;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;
    use HasLikes;
    use HasMedia;

    protected $fillable = [
        'title',
        'description',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch(Builder $query, string $search): void
    {
        $query->where('title', 'LIKE', "%$search%")
            ->orWhere('description', 'LIKE', "%$search%");
    }
}
