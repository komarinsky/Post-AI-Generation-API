<?php

namespace App\Services;

use App\Models\Media;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewMediaNotification;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

final class MediaService
{
    public function store(Model $model, array $input): Media
    {
        $input['path'] = request()->file('file')->store(options: ['disk' => 'public']);

        return $model->media()->create($input);
    }

    public function getList(): LengthAwarePaginator
    {
        return Media::query()->latest()->paginate(request()->per_page);
    }

    public function update(Media $media, array $input): Media
    {
        $media->update($input);

        return $media;
    }

    public function destroy(Media $media): void
    {
        Storage::delete($media->path);

        $media->delete();
    }
}
