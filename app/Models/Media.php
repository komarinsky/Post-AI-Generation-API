<?php

namespace App\Models;

use App\Traits\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    use HasMedia;

    protected $fillable = [
        'title',
        'description',
        'path',
    ];

    public function mediaable(): MorphTo
    {
        return $this->morphTo();
    }
}
